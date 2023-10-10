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
        a.is_received,a.is_void,a.remarks")
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
        $order=ItemDistribution1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($order) {
            if ($order->is_received=='1') {
                return response()->error('Gagal',501,'Data tidak bisa dibatalkan, distribusi sudah diterima');
            } else if ($order->is_void=='1') {
                return response()->error('Gagal',501,'Data sudah dibatalkan');
            } else if ($order->is_process=='1') {
                return response()->error('Gagal',501,'Data tidak bisa dibatalkan, permintaan sudah dibatalkan');
            }
        } else {
            return response()->error('',501,'Dokumen pemesanan tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$order->sysid;
            $order->void_date=Date('Y-m-d H:i:s');
            $order->void_by=PagesHelp::Users($request)->sysid;
            $order->is_void='1';
            $order->request_state='VOID';
            $order->save();
            DB::commit();
            return response()->success('Success','Pembatalan permintaan barang Berhasil');
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
            $order=ItemDistribution1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($order)) {
                $order=new ItemDistribution1();
                $order->uuid_rec=Str::uuid();
                $order->documentid=8002;
                $order->doc_number=ItemDistribution1::GenerateNumber($header['ref_date']);
                $order->create_by=PagesHelp::Users($request)->sysid;

                $old['header']=null;
                $old['detail']=array();

                $operation='inserted';

            } else {
                if ($order->is_received=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah diterima');
                } else if ($order->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah dibatalkan');
                }

                #Get old document and rollback document inventory request
                $old['header']=ItemDistribution1::where('sysid',$order->sysid)->first();
                $old['detail']=ItemDistribution2::where('sysid',$order->sysid)->get();

                $old_request_id=isset($old['header']->request_id) ? $old['header']->request_id :-1;

                if ($old_request_id<>-1) {
                    foreach($old['detail'] as $rec) {
                        DB::update("UPDATE t_items_request2 SET distribution_sysid=-1,distribution_date=null,
                        distribution_number='',quantity_distribution=quantity_distribution - ?
                        WHERE sysid=? AND item_code=?",
                        [$rec->quantity_update,$old_request_id,$rec->item_code]);
                    }
                    $line_state='OPEN';
                    $ItemRequest2=ItemRequest2::selectRaw("sysid,item_sysid,item_code,quantity_distribution")
                    ->where('sysid',$old_request_id)->get();

                    foreach($ItemRequest2 as $rec) {
                        if ($rec->quantity_distribution<>0) {
                            $line_state='PARTIAL';
                        }
                    }
                    ItemRequest1::where('sysid',$old_request_id)
                    ->update([
                        'line_state'=>$line_state,
                        'is_process'=>'1',
                        'process_date'=>null,
                        'process_sysid'=>-1,
                        'process_number'=>''
                    ]);
                }
                #Deleted old document_distribustion
                ItemDistribution2::where('sysid',$order->sysid)->delete();

                $operation='updated';

                $order->update_by = PagesHelp::Users($request)->sysid;
                $old_request_id   = isset($old['header']->request_sysid) ? $old['header']->request_sysid :-1;


            }
            $order->ref_date  = $header['ref_date'];
            $order->ref_time  = $header['ref_time'];
            $order->request_id= isset($header['request_id']) ? $header['request_id'] :'-';
            $order->ref_number= isset($header['ref_number']) ? $header['ref_number'] :'';

            $order->location_id_to = $header['location_id_to'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$order->location_id_to)->first();
            $order->location_name_to = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $order->location_id_from = $header['location_id_from'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$order->location_id_from)->first();
            $order->location_name_from = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $order->remarks    = isset($header['remarks']) ? $header['remarks'] :'';
            $order->item_group = isset($header['item_group']) ? $header['item_group'] :'';
            $order->transfer_type = '';
            $order->save();
            $sysid = $order->sysid;
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
                    $reqLine = ItemRequest2::where('sysid',$order->request_id)->where('item_code',$line->item_code)->first();
                    if ($reqLine){
                        ItemRequest2::where('sysid',$order->request_id)->where('item_code',$line->item_code)
                        ->update([
                            'distribution_sysid'=>$order->sysid,
                            'distribution_date'=>$order->ref_date. ' '.$order->ref_time,
                            'distribution_number'=>$order->doc_number,
                            'quantity_distribution'=>$reqLine->quantity_distribution + $line->quantity_update
                        ]);
                    } else {
                        DB::rollback();
                        return response()->error('',501,"Item ".$rec['item_name']." tidak ditemukan di permintaan barang");
                    }
                }
            }

            if ($order->request_id<>-1) {
                $line_state='COMPLETED';
                $ItemRequest2=ItemRequest2::where('sysid',$old_request_id)->get();
                foreach($ItemRequest2 as $rec) {
                    if ($rec->quantity_request>$rec->quantity_distribution) {
                        $line_state='PARTIAL';
                    }
                }
                ItemRequest1::where('sysid',$order->request_id)
                ->update([
                    'line_state'=>$line_state,
                    'is_process'=>'1',
                    'process_date'=>$order->ref_date. ' '.$order->ref_time,
                    'process_sysid'=>$order->sysid,
                    'process_number'=>$order->doc_number
                ]);
            }

            $order->cost=$cost;
            $order->save();

            DB::UPDATE("UPDATE t_items_distribution2 a INNER JOIN m_items b ON a.item_code=b.item_code
            SET a.item_sysid=b.sysid WHERE a.sysid=?",[$order->sysid]);

            $feedback=HelpersInventory::ItemCard($sysid,'DISTRIBUTION-OUT',$operation,'OUT');

            if ($feedback['success']==true) {
                $new['header'] = ItemDistribution1::where('sysid',$order->sysid)->first();
                $new['detail'] = ItemDistribution2::where('sysid',$order->sysid)->get();
                DataLog::create($sysid,$order->documentid,$order->sysid,$order->doc_number,'INV-DISTRIBUTION',$operation,$old,$new);
                DB::commit();
                return response()->success('Success','Simpan distribusi barang berhasil');
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
}
