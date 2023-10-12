<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\ItemRequest1;
use App\Models\Inventory\ItemRequest2;
use App\Models\Inventory\ItemDistribution1;
use App\Models\Inventory\ItemDistribution2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Warehouse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PagesHelp;
use HelpersInventory;
use DataLog;


class ItemDistributionController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 50;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1 :'1899-01-01';
        $date2 = isset($request->date2) ? $request->date2 :'1899-01-01';
        $data=ItemDistribution1::from('t_items_distribution1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.ref_time,a.ref_number,a.location_name_to,a.location_name_from,
        a.is_received,a.is_void,a.remarks,b.descriptions as line_state,a.cost")
        ->join("m_standard_code as b","a.line_state","=","b.standard_code")
        ->where('a.ref_date','>=',$date1)
        ->where('a.ref_date','<=',$date2);
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.ref_number', 'like', $filter);
                $q->orwhere('a.location_name_to', 'like', $filter);
                $q->orwhere('a.location_name_from', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, $sorting)->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $distribution=ItemDistribution1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($distribution) {
            if ($distribution->is_received=='1') {
                return response()->error('Gagal',501,'Data tidak bisa dibatalkan, distribusi sudah diterima');
            } else if ($distribution->is_void=='1') {
                return response()->error('Gagal',501,'Data sudah dibatalkan');
            } else if ($distribution->is_process=='1') {
                return response()->error('Gagal',501,'Data tidak bisa dibatalkan, permintaan dalam proses pengiriman');
            }
        } else {
            return response()->error('',501,'Dokumen pemesanan tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$distribution->sysid;
            $distribution->void_date=Date('Y-m-d H:i:s');
            $distribution->void_by=PagesHelp::Users($request)->sysid;
            $distribution->is_void='1';
            $distribution->line_state='C005@V';
            $distribution->save();
            $old['header']=ItemDistribution1::where('sysid',$sysid)->first();
            $old['detail']=ItemDistribution2::where('sysid',$sysid)->get();
            DataLog::create($sysid,$distribution->documentid,$distribution->sysid,$distribution->doc_number,'INV-DISTRIBUTION','DELETED',$old,"-");
            DB::commit();
            return response()->success('Success','Pembatalan distribusi barang Berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function store(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $detail=$data['detail'];
        $validator=Validator::make($header,[
            'ref_date'=>'bail|required|date',
            'location_id_from'=>'bail|required|exists:m_warehouse,sysid',
            'location_id_to'=>'bail|required|exists:m_warehouse,sysid',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id_from.required'=>'Lokasi asal distribusi harus diisi',
            'location_id_from.exists'=>'Lokasi asal distribusi tidak ditemukan dimaster',
            'location_id_to.required'=>'Lokasi tujuan distribusi harus diisi',
            'location_id_to.exists'=>'Lokasi tujuan distribusi tidak ditemukan dimaster',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_issue'=>'bail|required',
            '*.quantity_distribution'=>'bail|required|numeric|min:1',
            '*.item_cost'=>'bail|required|numeric|min:1',
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.mou_issue.required'=>'Satuan Permintaan harus diisi',
            '*.quantity_distribution.min'=>'Jumlah distribusi harus diisi/lebih besar dari NOL',
            '*.item_code.distinct'=>'Kode barang :input terduplikasi (terinput lebih dari 1)',
            '*.item_cost.required'=>'Harga item harus diisi',
            '*.item_cost.min'=>'Jumlah item harus diisi/lebih besar dari NOL',
        ]);

        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        $request_id=-1;
        if ($header['ref_number']<>'') {
            $req=ItemRequest1::where('doc_number',$header['ref_number'])
            ->whereNotIn('request_state',['OPEN','VOID'])
            ->first();
            if ($req){
                $request_id=$req->sysid;
                if ($req->location_id_from<>$header['location_id_to']) {
                    return response()->error('',501,'lokasi tujuan tidak sama dengan dokumen permintaan');
                } else if ($req->location_id_to<>$header['location_id_from']) {
                    return response()->error('',501,'lokasi asal tidak sama dengan dokumen permintaan');
                }
            } else {
                return response()->error('',501,'Dokumen permintaan barang [ '.$header['ref_number'].' ] tidak ditemukan');
            }
         }

        DB::beginTransaction();
        try{
            $distribution=ItemDistribution1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($distribution)) {
                $distribution=new ItemDistribution1();
                $distribution->uuid_rec=Str::uuid();
                $distribution->documentid=8002;
                $distribution->doc_number=ItemDistribution1::GenerateNumber($header['ref_date']);
                $distribution->create_by=PagesHelp::Users($request)->sysid;

                $old['header']=null;
                $old['detail']=array();

                $operation='CREATED';
                if (ItemDistribution1::where('request_id',$header['request_id'])->where('line_state','<>','C005@V')->exists()) {
                    return response()->error('',501,'Permintaan '.$header['ref_number'].' sudah diproses distribusi');
                }

            } else {
                if ($distribution->is_received=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah diterima');
                } else if ($distribution->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah dibatalkan');
                } else if ($distribution->line_state!='C005@O') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah terkonfirmasi (ON DELIVERED)/diterima');
                }

                #Get old document and rollback document inventory request
                $old['header']=ItemDistribution1::where('sysid',$distribution->sysid)->first();
                $old['detail']=ItemDistribution2::where('sysid',$distribution->sysid)->get();
                #Deleted old document_distribustion
                ItemDistribution2::where('sysid',$distribution->sysid)->delete();

                $operation='UPDATED';

                $distribution->update_by = PagesHelp::Users($request)->sysid;
                $old_request_id   = isset($old['header']->request_sysid) ? $old['header']->request_sysid :-1;
            }
            $distribution->ref_date  = $header['ref_date'];
            $distribution->ref_time  = $header['ref_time'];
            $distribution->request_id= isset($header['request_id']) ? $header['request_id'] :'-';
            $distribution->ref_number= isset($header['ref_number']) ? $header['ref_number'] :'';

            $distribution->location_id_to = $header['location_id_to'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$distribution->location_id_to)->first();
            $distribution->location_name_to = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $distribution->location_id_from = $header['location_id_from'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$distribution->location_id_from)->first();
            $distribution->location_name_from = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $distribution->remarks       = isset($header['remarks']) ? $header['remarks'] :'';
            $distribution->item_group    = isset($header['item_group']) ? $header['item_group'] :'';
            $distribution->transfer_type = '';
            $distribution->line_state    = 'C005@O';
            $distribution->save();
            $sysid = $distribution->sysid;
            $cost  = 0;
            foreach($detail as $rec) {
                $line= new ItemDistribution2();
                $line->sysid     = $sysid;
                $line->line_no   = $rec['line_no'];
                $line->item_sysid= -1;
                $line->item_code = $rec['item_code'];
                $line->item_name = $rec['item_name'];
                $line->mou_issue = $rec['mou_issue'];
                $line->convertion= $rec['convertion'];
                $line->mou_inventory = $rec['mou_inventory'];
                $line->quantity_request = $rec['quantity_request'];
                $line->quantity_distribution = $rec['quantity_distribution'];
                $line->quantity_update = $rec['quantity_update'];
                $line->item_cost = $rec['item_cost'];
                $line->line_cost = $rec['line_cost'];
                $line->quantity_update = $rec['quantity_update'];
                $line->remarks   = isset($rec['remarks']) ? $rec['remarks'] :'';
                $line->account_transfer  = isset($rec['account_transfer']) ? $rec['account_transfer'] :'';
                $line->account_inventory = isset($rec['account_inventory']) ? $rec['account_inventory'] :'';
                $line->save();

                #Calculate Cost and update Inventory request
                $cost=$cost + $line->line_cost;
            }

            $distribution->cost=$cost;
            $distribution->save();

            DB::UPDATE("UPDATE t_items_distribution2 a INNER JOIN m_items b ON a.item_code=b.item_code
            SET a.item_sysid=b.sysid WHERE a.sysid=?",[$distribution->sysid]);

            $new['header'] = ItemDistribution1::where('sysid',$distribution->sysid)->first();
            $new['detail'] = ItemDistribution2::where('sysid',$distribution->sysid)->get();
            DataLog::create($sysid,$distribution->documentid,$distribution->sysid,$distribution->doc_number,'INV-DISTRIBUTION',$operation,$old,$new);

            DB::commit();
            return response()->success('Success','Simpan distribusi barang berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function posting(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $detail=$data['detail'];
        $validator=Validator::make($header,[
            'ref_date'=>'bail|required|date',
            'location_id_from'=>'bail|required|exists:m_warehouse,sysid',
            'location_id_to'=>'bail|required|exists:m_warehouse,sysid',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id_from.required'=>'Lokasi asal distribusi harus diisi',
            'location_id_from.exists'=>'Lokasi asal distribusi tidak ditemukan dimaster',
            'location_id_to.required'=>'Lokasi tujuan distribusi harus diisi',
            'location_id_to.exists'=>'Lokasi tujuan distribusi tidak ditemukan dimaster',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_issue'=>'bail|required',
            '*.quantity_distribution'=>'bail|required|numeric|min:1',
            '*.item_cost'=>'bail|required|numeric|min:1',
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.mou_issue.required'=>'Satuan Permintaan harus diisi',
            '*.quantity_distribution.min'=>'Jumlah distribusi harus diisi/lebih besar dari NOL',
            '*.item_code.distinct'=>'Kode barang :input terduplikasi (terinput lebih dari 1)',
            '*.item_cost.required'=>'Harga item harus diisi',
            '*.item_cost.min'=>'Jumlah item harus diisi/lebih besar dari NOL',
        ]);

        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        $request_id=-1;
        if ($header['ref_number']<>'') {
            $req=ItemRequest1::where('doc_number',$header['ref_number'])
            ->whereNotIn('request_state',['C005@O','C005@V'])
            ->first();
            if ($req){
                $request_id=$req->sysid;
                if ($req->location_id_from<>$header['location_id_to']) {
                    return response()->error('',501,'lokasi tujuan tidak sama dengan dokumen permintaan');
                } else if ($req->location_id_to<>$header['location_id_from']) {
                    return response()->error('',501,'lokasi asal tidak sama dengan dokumen permintaan');
                }
            } else {
                return response()->error('',501,'Dokumen permintaan barang [ '.$header['ref_number'].' ] tidak ditemukan');
            }
         }

        DB::beginTransaction();
        try{
            $distribution=ItemDistribution1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')
            ->first();
            if ($distribution) {
                if ($distribution->is_received=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah diterima');
                } else if ($distribution->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah dibatalkan');
                } else if ($distribution->line_state=='C005@D') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah terkonfirmasi dikirim');
                }
                #Get old document and rollback document inventory request
                $old['header']=ItemDistribution1::where('sysid',$distribution->sysid)->first();
                $old['detail']=ItemDistribution2::where('sysid',$distribution->sysid)->get();

                ItemDistribution2::where('sysid',$distribution->sysid)->delete();

                $operation='updated';

                $distribution->confirm_by = PagesHelp::Users($request)->sysid;
                $distribution->confirm_date=Date('Y-m-d H:i:s');

                $old_request_id   = isset($old['header']->request_sysid) ? $old['header']->request_sysid :-1;
            } else {
                DB::rollback();
                return response()->error('Gagal',501,'Dokumen distribusi barang tidak ditemukan');
            }

            $distribution->ref_date  = $header['ref_date'];
            $distribution->ref_time  = $header['ref_time'];
            $distribution->request_id= $header['request_id'];
            $distribution->ref_number= $header['ref_number'];

            $distribution->location_id_to = $header['location_id_to'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$distribution->location_id_to)->first();
            $distribution->location_name_to = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $distribution->location_id_from = $header['location_id_from'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$distribution->location_id_from)->first();
            $distribution->location_name_from = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $distribution->remarks       = isset($header['remarks']) ? $header['remarks'] :'';
            $distribution->item_group    = isset($header['item_group']) ? $header['item_group'] :'';
            $distribution->transfer_type = '';
            $distribution->line_state    = 'C005@D';
            $distribution->save();

            $sysid = $distribution->sysid;
            $cost  = 0;
            foreach($detail as $rec) {
                $line= new ItemDistribution2();
                $line->sysid     = $sysid;
                $line->line_no   = $rec['line_no'];
                $line->item_sysid= -1;
                $line->item_code = $rec['item_code'];
                $line->item_name = $rec['item_name'];
                $line->mou_issue = $rec['mou_issue'];
                $line->convertion= $rec['convertion'];
                $line->mou_inventory = $rec['mou_inventory'];
                $line->quantity_request = $rec['quantity_request'];
                $line->quantity_distribution = $rec['quantity_distribution'];
                $line->quantity_update = $rec['quantity_update'];
                $line->item_cost = $rec['item_cost'];
                $line->line_cost = $rec['line_cost'];
                $line->quantity_update = $rec['quantity_update'];
                $line->remarks   = isset($rec['remarks']) ? $rec['remarks'] :'';
                $line->account_transfer  = isset($rec['account_transfer']) ? $rec['account_transfer'] :'';
                $line->account_inventory = isset($rec['account_inventory']) ? $rec['account_inventory'] :'';
                $line->save();

                #Calculate Cost and update Inventory request
                $cost=$cost + $line->line_cost;
                if ($request_id<>-1) {
                    $reqLine = ItemRequest2::where('sysid',$distribution->request_id)->where('item_code',$line->item_code)->first();
                    if ($reqLine){
                        ItemRequest2::where('sysid',$distribution->request_id)->where('item_code',$line->item_code)
                        ->update([
                            'distribution_sysid'=>$distribution->sysid,
                            'distribution_date'=>$distribution->ref_date. ' '.$distribution->ref_time,
                            'distribution_number'=>$distribution->doc_number,
                            'quantity_distribution'=>$reqLine->quantity_distribution + $line->quantity_update
                        ]);
                    } else {
                        DB::rollback();
                        return response()->error('',501,"Item ".$rec['item_name']." tidak ditemukan di permintaan barang");
                    }
                }
            }

            if ($distribution->request_id<>-1) {
                $line_state='C005@C';
                $ItemRequest2=ItemRequest2::selectRaw("quantity_request,quantity_distribution,mou_inventory")->where('sysid',$distribution->request_id)->get();
                foreach($ItemRequest2 as $rec) {
                    if ($rec->quantity_request>$rec->quantity_distribution) {
                        $line_state='C005@P';
                    }
                    if ($rec->quantity_request<$rec->quantity_distribution) {
                        DB::rollback();
                        return response()->error('',501,"Item ".$rec['item_name'].", Jumlah distribusi (".$rec->quantity_distribution." ".$rec->mou_inventory.
                        ") melebihi jumlah permintaan (".$rec->quantity_request." ".$rec->mou_inventory.")");
                    }

                }
                ItemRequest1::where('sysid',$distribution->request_id)
                ->update([
                    'line_state'=>$line_state,
                    'is_process'=>'1',
                    'process_date'=>$distribution->ref_date. ' '.$distribution->ref_time,
                    'process_sysid'=>$distribution->sysid,
                    'process_number'=>$distribution->doc_number,
                ]);
            }

            $distribution->cost=$cost;
            $distribution->save();

            DB::UPDATE("UPDATE t_items_distribution2 a INNER JOIN m_items b ON a.item_code=b.item_code
            SET a.item_sysid=b.sysid WHERE a.sysid=?",[$distribution->sysid]);

            $feedback=HelpersInventory::ItemCard($sysid,'DISTRIBUTION-OUT','inserted','OUT');

            if ($feedback['success']==true) {
                $new['header'] = ItemDistribution1::where('sysid',$distribution->sysid)->first();
                $new['detail'] = ItemDistribution2::where('sysid',$distribution->sysid)->get();
                DataLog::create($sysid,$distribution->documentid,$distribution->sysid,$distribution->doc_number,'INV-DIST-CONFIRM','CONFIRM',$old,$new);
                DB::commit();
                return response()->success('Success','Konfirmasi distribusi barang berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function get(Request $request)
    {
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'-';
        $is_cost=isset($request->getcost) ? $request->getcost :'0';
        $data['header']=ItemDistribution1::where('uuid_rec',$uuidrec)->first();
        $data['detail']=ItemDistribution2::where('sysid',isset($data['header']->sysid) ? $data['header']->sysid :-1)->get();
        return response()->success('Success', $data);
    }

    public function confirm(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 50;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1 :'1899-01-01';
        $date2 = isset($request->date2) ? $request->date2 :'1899-01-01';
        $location_id=isset($request->location_id) ? $request->location_id :'-1';
        $status=isset($request->status) ? $request->status :'0';

        $data=ItemDistribution1::from('t_items_distribution1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.ref_time,a.ref_number,a.location_name_to,a.location_name_from,
        a.is_received,a.is_void,a.remarks,b.descriptions as line_states,a.line_state,a.cost,c.full_name as confirm_by,confirm_date,d.full_name as received_by,
        a.received_date,a.uuid_rec")
        ->join("m_standard_code as b","a.line_state","=","b.standard_code")
        ->leftjoin("o_users as c","a.confirm_by","=","c.sysid")
        ->leftjoin("o_users as d","a.received_by","=","d.sysid")
        ->where('a.location_id_to',$location_id);
        if ($status=='0'){
            $data=$data->where('a.line_state','C005@D')
            ->where('is_void','0');
        } else {
            $data=$data->where('a.ref_date','>=',$date1)
            ->where('a.ref_date','<=',$date2)
            ->where('a.line_state','<>','C005@V');
        }

        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.ref_number', 'like', $filter);
                $q->orwhere('a.location_name_to', 'like', $filter);
                $q->orwhere('a.location_name_from', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, $sorting)->paginate($limit);
        return response()->success('Success', $data);
    }

    public function accepted(Request $request) {
        $uuid_rec= isset($request->uuid) ? $request->uuid  :'';
        DB::beginTransaction();
        try{
            $distribution=ItemDistribution1::where('uuid_rec',$uuid_rec)->first();
            if ($distribution) {
                if ($distribution->line_state=='C005@C') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Proses ditolak, transaksi distribusi sudah diterima');
                } else if ($distribution->line_state=='C005@V') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Proses ditolak, transaksi distribusi ini sudah dibatalkan (void)');
                } else if ($distribution->line_state=='C005@O') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Proses ditolak, transaksi distribusi belum terkonfirmasi dikirim');
                }
            } else {
                DB::rollback();
                return response()->error('Gagal',501,'Dokumen distribusi barang tidak ditemukan');
            }
            $distribution->received_by   = PagesHelp::Users($request)->sysid;
            $distribution->received_date = Date('Y-m-d H:i:s');
            $distribution->line_state    = 'C005@C';
            $distribution->save();
            $sysid=$distribution->sysid;
            if ($distribution->request_id<>-1) {
                $detail=ItemDistribution2::where('sysid',$distribution->sysid)->get();
                foreach($detail as $rec) {
                    DB::update("UPDATE t_items_request2 SET quantity_received=quantity_received+?
                    WHERE sysid=? AND item_code=?",[$rec->quantity_update,$distribution->request_id,$rec->item_code]);
                }
            }

            $feedback=HelpersInventory::ItemCard($sysid,'DISTRIBUTION-IN','inserted','IN');

            if ($feedback['success']==true) {
                $new['header'] = ItemDistribution1::where('sysid',$distribution->sysid)->first();
                $new['detail'] = ItemDistribution2::where('sysid',$distribution->sysid)->get();
                DataLog::create($sysid,$distribution->documentid,$distribution->sysid,$distribution->doc_number,'INV-DIST-RECEIVED','RECEIVED',"-",$new);
                DB::commit();
                return response()->success('Success','Penerimaan distribusi barang berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function rejected(Request $request) {
        $uuid_rec= isset($request->uuid) ? $request->uuid  :'';
        DB::beginTransaction();
        try{
            $distribution=ItemDistribution1::where('uuid_rec',$uuid_rec)->first();
            if ($distribution) {
                if ($distribution->line_state=='C005@C') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Proses ditolak, distribusi barang sudah diterima');
                } else if ($distribution->line_state=='C005@V') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Proses ditolak, distribusi barang sudah dibatalkan');
                } else if ($distribution->line_state=='C005@O') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Proses ditolak, distribusi belum dikonfirmasi');
                }
                #Get old document and rollback document inventory request
                $old_request_id   = isset($old['header']->request_sysid) ? $old['header']->request_sysid :-1;
            } else {
                DB::rollback();
                return response()->error('Gagal',501,'Dokumen distribusi barang tidak ditemukan');
            }
            $request_id =$distribution->request_id;
            $distribution->line_state    = 'C005@O';
            $distribution->confirm_by    = -1;
            $distribution->confirm_date  = null;
            $distribution->save();

            if ($request_id<>-1) {
                $detail=ItemDistribution2::where('sysid',$distribution->sysid)->get();
                foreach($detail as $rec) {
                    DB::update("UPDATE t_items_request2 SET quantity_distribution=quantity_distribution-?,
                    distribution_sysid=-1,distribution_date=null,distribution_number=''
                    WHERE sysid=? AND item_code=?",[$rec->quantity_update,$distribution->request_id,$rec->item_code]);
                }
                $line_state='C005@O';
                $ItemRequest2=ItemRequest2::selectRaw("quantity_request,quantity_distribution,mou_inventory")->where('sysid',$distribution->request_id)->get();
                foreach($ItemRequest2 as $rec) {
                    if ($rec->quantity_distribution<>0) {
                        $line_state='C005@P';
                    }
                    if ($rec->quantity_distribution<0) {
                        DB::rollback();
                        return response()->error('',501,"Item ".$rec->item_name.", Error jumlah distribusi menjadi minus");
                    }
                }
                ItemRequest1::where('sysid',$distribution->request_id)
                ->update([
                    'line_state'=>$line_state,
                    'is_process'=>'0',
                    'process_date'=>null,
                    'process_sysid'=>-1,
                    'process_number'=>'',
                ]);
            }

            $feedback=HelpersInventory::ItemCard($distribution->sysid,'DISTRIBUTION-OUT','deleted','IN');

            if ($feedback['success']==true) {
                $old="-";
                $new['header'] = ItemDistribution1::where('sysid',$distribution->sysid)->first();
                $new['detail'] = ItemDistribution2::where('sysid',$distribution->sysid)->get();
                DataLog::create(-1,$distribution->documentid,$distribution->sysid,$distribution->doc_number,'INV-DIST-CONFIRM','VOID',$old,$new);
                DB::commit();
                return response()->success('Success','Penolakan penerimaan distribusi berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }

		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }
}
