<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\ItemRequest1;
use App\Models\Inventory\ItemRequest2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Warehouse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PagesHelp;
use DataLog;



class ItemRequestController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 50;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1 :'1899-01-01';
        $date2 = isset($request->date2) ? $request->date2 :'1899-01-01';
        $data=ItemRequest1::from('t_items_request1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.ref_number,a.location_name_to,a.location_name_from,
        a.is_approved,a.is_void,a.is_process,a.request_state,a.remarks,a.line_state,a.process_date,a.process_number")
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
        $data   = $request->json()->all();
        $header = $data['header'];
        $order  = ItemRequest1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($order) {
            if ($order->is_approved=='1') {
                return response()->error('Gagal',501,'Data tidak bisa dibatalkan, permintaan sudah disetujui');
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
        $data   = $request->json()->all();
        $header = $data['header'];
        $detail = $data['detail'];
        $validator=Validator::make($header,[
            'ref_date'=>'bail|required|date',
            'location_id_from'=>'bail|required|exists:m_warehouse,sysid',
            'location_id_to'=>'bail|required|exists:m_warehouse,sysid',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id_from.required'=>'Lokasi permintaan harus diisi',
            'location_id_from.exists'=>'Lokasi permintaan tidak ditemukan dimaster',
            'location_id_to.required'=>'Lokasi tujuan harus diisi',
            'location_id_to.exists'=>'Lokasi tujuan tidak ditemukan dimaster',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_request'=>'bail|required',
            '*.quantity_request'=>'bail|required|numeric|min:1',
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.mou_request.required'=>'Satuan Permintaan harus diisi',
            '*.quantity_request.min'=>'Jumlah permintaan harus diisi/lebih besar dari NOL',
            '*.item_code.distinct'=>'Kode barang :input terduplikasi (terinput lebih dari 1)',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $order=ItemRequest1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();

            #create or update item request document
            if (!($order)) {
                $old='-';
                $operation='CREATED';
                $order=new ItemRequest1();
                $order->uuid_rec   = Str::uuid();
                $order->documentid = 8001;
                $order->doc_number = ItemRequest1::GenerateNumber($header['ref_date']);
                $order->create_by  = PagesHelp::Users($request)->sysid;
            } else {
                $operation='UPDATED';
                if ($order->is_approved=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah disetujui');
                } else if ($order->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah dibatalkan');
                } else if ($order->is_process=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah dibatalkan');
                }
                $old['header']=ItemRequest1::where('sysid',$order->sysid)->first();
                $old['detail']=ItemRequest2::where('sysid',$order->sysid)->get();
                $order->update_by=PagesHelp::Users($request)->sysid;
                ItemRequest2::where('sysid',$order->sysid)->delete();
            }

            $order->ref_date  = $header['ref_date'];
            $order->ref_time  = $header['ref_time'];
            $order->ref_number= isset($header['ref_number']) ? $header['ref_number'] :'';

            $order->location_id_to = $header['location_id_to'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$order->location_id_to)->first();
            $order->location_name_to = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $order->location_id_from = $header['location_id_from'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$order->location_id_from)->first();
            $order->location_name_from = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $order->remarks       = isset($header['remarks']) ? $header['remarks'] :'';
            $order->item_group    = isset($header['item_group']) ? $header['item_group'] :'';
            $order->request_state = 'OPEN';
            $order->save();

            #Save detail item request
            $sysid=$order->sysid;
            foreach($detail as $rec) {
                $line= new ItemRequest2();
                $line->sysid     = $sysid;
                $line->line_no   = $rec['line_no'];
                $line->item_code = $rec['item_code'];
                $line->item_name = $rec['item_name'];
                $line->mou_request = $rec['mou_request'];
                $line->convertion  = $rec['convertion'];
                $line->mou_inventory = $rec['mou_inventory'];
                $line->quantity_order   = $rec['quantity_order'];
                $line->quantity_request = $rec['quantity_request'];
                $line->remarks     = isset($rec['remarks']) ? $rec['remarks'] :'';
                $line->save();
            }
            DB::UPDATE("UPDATE t_items_request2 a INNER JOIN m_items b ON a.item_code=b.item_code
            SET a.item_sysid=b.sysid WHERE a.sysid=?",[$order->sysid]);

            $new['header']=ItemRequest1::where('sysid',$order->sysid)->first();
            $new['detail']=ItemRequest2::where('sysid',$order->sysid)->get();

            DataLog::create($sysid,$order->documentid,$order->sysid,$order->doc_number,'INV-REQUEST',$operation,$old,$new);

            DB::commit();
            return response()->success('Success','Simpan permintaan barang berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

   public function posting(Request $request) {
        $data   = $request->json()->all();
        $header = $data['header'];
        $detail = $data['detail'];
        $validator=Validator::make($header,[
            'ref_date'=>'bail|required|date',
            'location_id_from'=>'bail|required|exists:m_warehouse,sysid',
            'location_id_to'=>'bail|required|exists:m_warehouse,sysid',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id_from.required'=>'Lokasi permintaan harus diisi',
            'location_id_from.exists'=>'Lokasi permintaan tidak ditemukan dimaster',
            'location_id_to.required'=>'Lokasi tujuan harus diisi',
            'location_id_to.exists'=>'Lokasi tujuan tidak ditemukan dimaster',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_request'=>'bail|required',
            '*.quantity_request'=>'bail|required|numeric|min:1',
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.mou_request.required'=>'Satuan Permintaan harus diisi',
            '*.quantity_request.min'=>'Jumlah permintaan harus diisi/lebih besar dari NOL',
            '*.item_code.distinct'=>'Kode barang :input terduplikasi (terinput lebih dari 1)',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $order = ItemRequest1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($order)) {
                return response()->error('',501,'Dokumen permintaan barang tidak ditemukan');
            } else {
                if ($order->is_approved=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah disetujui');
                } else if ($order->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah dibatalkan');
                } else if ($order->is_process=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah diproses');
                }
                ItemRequest2::where('sysid',$order->sysid)->delete();
            }
            $order->ref_date   = $header['ref_date'];
            $order->ref_time   = $header['ref_time'];
            $order->ref_number = isset($header['ref_number']) ? $header['ref_number'] :'';

            $order->location_id_to = $header['location_id_to'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$order->location_id_to)->first();
            $order->location_name_to = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $order->location_id_from = $header['location_id_from'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$order->location_id_from)->first();
            $order->location_name_from = isset($warehouse->location_name) ? $warehouse->location_name :'';

            $order->remarks     = isset($header['remarks']) ? $header['remarks'] :'';
            $order->item_group  = isset($header['item_group']) ? $header['item_group'] :'';
            $order->is_approved = 1;
            $order->approved_by = PagesHelp::Users($request)->sysid;
            $order->approved_date = Date('Y-m-d H:i:s');
            $order->request_state = 'APPROVED';
            $order->save();

            $sysid=$order->sysid;
            foreach($detail as $rec) {
                $line= new ItemRequest2();
                $line->sysid=$sysid;
                $line->line_no=$rec['line_no'];
                $line->item_code=$rec['item_code'];
                $line->item_name=$rec['item_name'];
                $line->mou_request=$rec['mou_request'];
                $line->convertion=$rec['convertion'];
                $line->mou_inventory=$rec['mou_inventory'];
                $line->quantity_order=$rec['quantity_order'];
                $line->quantity_request=$rec['quantity_request'];
                $line->remarks=isset($rec['remarks']) ? $rec['remarks'] :'';
                $line->save();
            }
            DB::UPDATE("UPDATE t_items_request2 a INNER JOIN m_items b ON a.item_code=b.item_code
            SET a.item_sysid=b.sysid WHERE a.sysid=?",[$order->sysid]);
            DB::commit();
            return response()->success('Success','Simpan permintaan barang berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function unposting(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];

        $order=ItemRequest1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($order) {
            if ($order->is_approved=='0') {
                DB::rollback();
                return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan masih open');
            } else if ($order->is_void=='1') {
                DB::rollback();
                return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah dibatalkan');
            } else if ($order->is_process=='1') {
                DB::rollback();
                return response()->error('Gagal',501,'Data tidak bisa diupdate, permintaan sudah diproses');
            }
        } else {
            return response()->error('',501,'Dokumen pemesanan tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid = $order->sysid;
            $order->approved_date = null;
            $order->approved_by   = -1;
            $order->is_approved   = '0';
            $order->request_state = 'OPEN';
            $order->save();
            DB::commit();
            return response()->success('Success','Persetujuan pemesanan barang Berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function get(Request $request)
    {
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'-';
        $is_cost=isset($request->getcost) ? $request->getcost :'0';
        $data['header']=ItemRequest1::where('uuid_rec',$uuidrec)->first();
        if ($data['header']) {
            if ($is_cost=='0') {
                $data['detail']=ItemRequest2::from("t_items_request2 as a")
                ->selectRaw("a.line_no,a.item_sysid,a.item_code,a.item_name,a.mou_request,a.convertion,a.mou_inventory,
                a.quantity_order,a.quantity_request,a.quantity_distribution,a.quantity_received,a.remarks,
                a.distribution_date,a.distribution_number")
                ->where('sysid',$data['header']->sysid)->get();
            } else {
                $location_id=$data['header']->location_id_to;
                $data['detail']=ItemRequest2::from('t_items_request2 as a')
                ->selectRaw("a.line_no,a.item_sysid,a.item_code,a.item_name,a.mou_request,a.convertion,a.mou_inventory,
                a.quantity_order,a.quantity_request,a.quantity_distribution,a.quantity_received,a.remarks,IFNULL(b.on_hand,0) as on_hand,
                IFNULL(b.cogs,0) as cogs")
                ->leftjoin("m_items_stock as b",function($join) use($location_id) {
                    $join->on("a.item_sysid","=","b.item_sysid");
                    $join->on("b.location_id","=",DB::raw("$location_id"));
                })
                ->where('a.sysid',$data['header']->sysid)->get();
            }
        }
        return response()->success('Success', $data);
    }

    public function open(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 50;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1 :'1899-01-01';
        $date2 = isset($request->date2) ? $request->date2 :'1899-01-01';
        $data=ItemRequest1::from('t_items_request1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.ref_number,a.location_name_to,a.location_name_from,
        a.is_approved,a.is_void,a.is_process,a.request_state,a.remarks,a.line_state")
        ->whereIn('a.line_state',['OPEN','PARTIAL'])
        ->where('a.is_void','0');

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

    public function detail(Request $request)
    {
        $uuidrec=isset($request->uuid_rec) ? $request->uuid_rec :'-';
        $data=ItemRequest1::from('t_item_request1 as a')
        ->selectRaw("b.sysid,b.line_no,b.item_sysid,b.item_code,b.item_name,b.mou_purchase,b.conversion,b.mou_inventory,
        b.quantity_order,b.quantity_received,b.price,b.prc_discount1,b.prc_discount2,b.prc_tax")
        ->join('t_item_request2 as b','a.sysid','=','b.sysid')
        ->where('a.uuid_rec',$uuidrec)->get();
        return response()->success('Success', $data);
    }


}
