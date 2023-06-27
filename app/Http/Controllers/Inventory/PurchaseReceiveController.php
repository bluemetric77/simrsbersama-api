<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\PurchaseOrder1;
use App\Models\Inventory\PurchaseOrde2;
use App\Models\Inventory\PurchaseReceive1;
use App\Models\Inventory\PurchaseReceive2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PagesHelp;


class PurchaseReceiveController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1 :'1899-01-01';
        $date2 = isset($request->date2) ? $request->date2 :'1899-01-01';
        $data=PurchaseReceive1::from('t_purchase_receive1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.ref_number,a.partner_name,a.total,a.expired_date,b.location_name,
        c.descriptions as purchase_type,d.descriptions as order_type,a.state,order_state,is_void,is_posted")
        ->leftjoin("m_warehouse as b","a.location_id","=","b.sysid")
        ->leftjoin("m_standard_code as c","a.purchase_type","=","c.standard_code")
        ->leftjoin("m_standard_code as d","a.order_type","=","c.standard_code")
        ->where('a.ref_date','>=',$date1)
        ->where('a.ref_date','>=',$date2);
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.ref_number', 'like', $filter);
                $q->orwhere('a.partner_name', 'like', $filter);
                $q->orwhere('b.location_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, $sorting)->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $order=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($order) {
            if ($order->is_posted=='1') {
                return response()->error('',501,'Dokumen pemesanan sudah disetujui');            
            } else if ($order->is_void=='1') {
                return response()->error('',501,'Dokumen pemesanan sudah dibatalkan');            
            } else if($order->order_state<>'OPEN') {
                return response()->error('Gagal',501,'Data tidak bisa diupdate, PO sudah ada penerimaan');
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
            $order->save();
            DB::commit();
            return response()->success('Success','Persetujuan pemesanan barang Berhasil');
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
            'ref_date'=>'bail|required',
            'due_date'=>'bail|required',
            'location_id'=>'bail|required|exists:m_warehouse,sysid',
            'partner_id'=>'bail|required|exists:m_supplier,sysid'
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'due_date.required'=>'Tanggal jatuh tempo harus diisi',
            'location_id.required'=>'Gudang harus diisi',
            'location_id.exists'=>'ID Lokasi tidak ditemukan dimaster',
            'partner_id.required'=>'Supplier harus diisi',
            'partner_id.exists'=>'ID Supplier tidak ditemukan dimaster'
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_purchase'=>'bail|required',
            '*.qty_received'=>'bail|required|numeric|min:1',
            '*.price'=>'bail|required|numeric|min:1',
            '*.prc_discount1'=>'bail|required|numeric|min:0|max:100',
            '*.prc_discount2'=>'bail|required|numeric|min:0|max:100',
            '*.prc_tax'=>'bail|required|numeric|min:0|max:100',
            '*.conversion'=>'bail|required|numeric|min:1'
        ],[
            '*.item_code.required'=>'Kode inventory harus diisi',
            '*.item_code.exists'=>'Kode inventory :input tidak ditemukan dimaster',
            '*.mou_purchase.required'=>'Satuan beli harus diisi',
            '*.qty_received.min'=>'Jumlah order (Draft) harus diisi/lebih besar dari NOL',
            '*.price.min'=>'Harga pembelian tidak boleh NOL',
            '*.item_code.distinct'=>'Kode barang/jasa :input terduplikasi (terinput lebih dari 1)',
            '*.conversion.min'=>'Isi kemasan harus diisi/lebih besar dari NOL',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        $total = 0 ;
        foreach($detail as $row){
            $total= $total + floatval($row['total']);
        }
        if ($total <=0){
           return response()->error('',501,"Total PO tidak boleh NOL");
        }
        $header['amount']=0;
        $header['discount1']=0;
        $header['discount2']=0;
        $header['tax']=0;
        $header['total']=0;
        foreach($detail as $line) {
            $header['amount']=$header['amount'] + ($line['qty_received'] * $line['price']);
            $header['discount1']=$header['discount1'] + $line['discount1'];
            $header['discount2']=$header['discount2'] + $line['discount2'];
            $header['tax']=$header['tax'] + $line['tax'];
            $header['total']=$header['total'] + $line['total'];
        }

        DB::beginTransaction();
        try{
            $sysid_order=$header['order_sysid'];
            $partner=Supplier::select('supplier_name')->where('sysid',$header['partner_id'])->first();    
            $order=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($order)) {
                $order=new PurchaseReceive1();
                $order->uuid_rec=Str::uuid(); 
                $order->doc_number=PurchaseReceive1::GenerateNumber($header['ref_date']);
                $order->create_by=PagesHelp::Users($request)->sysid;
            } else {
                if ($order->is_process=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, Penerimaan sudah dibuatkan piutang - '.$order->payable_number);
                }
                $order->update_by=PagesHelp::Users($request)->sysid;
                PurchaseReceive2::where('sysid',$order->sysid)->delete();
            }
            $order->ref_date=$header['ref_date'];
            $order->invoice_number=isset($header['invoice_number']) ? $header['invoice_number'] :'';
            $order->order_sysid=isset($header['order_sysid']) ? $header['order_sysid'] :'-1';
            $order->order_number=isset($header['order_number']) ? $header['order_number'] :'-';
            $order->ref_document=$header['ref_document'];
            $order->due_date=$header['due_date'];
            $order->location_id=$header['location_id'];
            $order->partner_id=$header['partner_id'];
            $order->partner_name=$partner->supplier_name;
            $order->term_id=$header['term_id'];
            $order->curr_rate=isset($header['curr_rate']) ? $header['curr_rate'] :'1';
            $order->curr_code=isset($header['curr_code']) ? $header['curr_code'] :'IDR';
            $order->amount=$header['amount'];
            $order->discount1=$header['discount1'];
            $order->discount2=$header['discount2'];
            $order->tax=$header['tax'];
            $order->total=$header['total'];
            $order->is_tax=isset($header['is_tax']) ? $header['is_tax'] :'0';
            $order->item_group=isset($header['item_group']) ? $header['item_group'] :'';
            $order->save();
            $sysid=$order->sysid;
            foreach($detail as $rec) {
                $line= new PurchaseReceive2();
                $line->sysid=$sysid;
                $line->line_no=$rec['line_no'];
                $line->item_code=$rec['item_code'];
                $line->item_name=$rec['item_name'];
                $line->mou_purchase=$rec['mou_purchase'];
                $line->conversion=$rec['conversion'];
                $line->mou_inventory=$rec['mou_inventory'];
                $line->price=$rec['price'];
                $line->qty_received=$rec['qty_received'];
                $line->qty_order=$rec['qty_order'];
                $line->prc_discount1=$rec['prc_discount1'];
                $line->discount1=$rec['discount1'];
                $line->prc_discount2=$rec['prc_discount2'];
                $line->discount2=$rec['discount2'];
                $line->prc_tax=$rec['prc_tax'];
                $line->tax=$rec['tax'];
                $line->total=$rec['total'];
                $line->order_sysid=$order->order_id;
                $line->order_number=$order->order_number;
                $line->qty_update=floatval($line->qty_received) * floatval($line->conversion); 
                $line->cost_update=floatval($line->total)/floatval($line->qty_update);
                $line->save();
            }
            DB::update("UPDATE t_purchase_receive2 a INNER JOIN m_items b ON a.item_code=b.item_code
                SET a.item_id=b.sysid WHERE a.sysid=?",[$sysid]);
            DB::commit();
            return response()->success('Success','Simpan pembelian barang berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

   public function posting(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $detail=$data['detail'];
        $header['amount']=0;
        $header['discount1']=0;
        $header['discount2']=0;
        $header['tax']=0;
        $header['total']=0;
        foreach($detail as $line) {
            $header['amount']=$header['amount'] + ($line['qty_order'] * $line['price']);
            $header['discount1']=$header['discount1'] + $line['discount1'];
            $header['discount2']=$header['discount2'] + $line['discount2'];
            $header['tax']=$header['tax'] + $line['tax'];
            $header['total']=$header['total'] + $line['total'];
        }
        $order=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($order) {
            if ($order->is_posted=='1') {
                return response()->error('',501,'Dokumen pemesanan sudah disetujui');            
            } else if ($order->is_void=='1') {
                return response()->error('',501,'Dokumen pemesanan sudah dibatalkan');            
            } else if($order->order_state<>'OPEN') {
                return response()->error('Gagal',501,'Data tidak bisa diupdate, PO sudah ada penerimaan');
            }
        } else {
            return response()->error('',501,'Dokumen pemesanan tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$order->sysid;
            $order->posted_date=Date('Y-m-d H:i:s');
            $order->posted_by=PagesHelp::Users($request)->sysid;
            $order->is_posted='1';
            $order->amount=$header['amount'];
            $order->discount1=$header['discount1'];
            $order->discount2=$header['discount2'];
            $order->tax=$header['tax'];
            $order->state='Posted';
            $order->save();
            $sysid=$order->sysid;
            foreach($detail as $rec) {
                $line= PurchaseReceive2::where('sysid',$sysid)
                ->where('line_no',$rec['line_no'])
                ->first();
                if ($line){
                    $line->price=$rec['price'];
                    $line->qty_order=$rec['qty_order'];
                    $line->prc_discount1=$rec['prc_discount1'];
                    $line->discount1=$rec['discount1'];
                    $line->prc_discount2=$rec['prc_discount2'];
                    $line->discount2=$rec['discount2'];
                    $line->prc_tax=$rec['prc_tax'];
                    $line->tax=$rec['tax'];
                    $line->total=$rec['total'];
                    $line->save();
                }
            }
            DB::commit();
            return response()->success('Success','Persetujuan pemesanan barang Berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }
 

   public function unposting(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];

        $order=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($order) {
            if ($order->is_posted=='0') {
                return response()->error('',501,'Dokumen pemesanan sudah disetujui');            
            } else if ($order->is_void=='1') {
                return response()->error('',501,'Dokumen pemesanan sudah dibatalkan');            
            } else if($order->order_state<>'OPEN') {
                return response()->error('Gagal',501,'Data tidak bisa diupdate, PO sudah ada penerimaan');
            }
        } else {
            return response()->error('',501,'Dokumen pemesanan tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$order->sysid;
            $order->posted_date=Date('Y-m-d H:i:s');
            $order->posted_by=PagesHelp::Users($request)->sysid;
            $order->is_posted='0';
            $order->state='Draft';
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
        $data['header']=PurchaseReceive1::where('uuid_rec',$uuidrec)->first();
        if ($data['header']) {
            $data['detail']=PurchaseReceive2::where('sysid',$data['header']->sysid)->get();
        }
        return response()->success('Success', $data);
    }
}
