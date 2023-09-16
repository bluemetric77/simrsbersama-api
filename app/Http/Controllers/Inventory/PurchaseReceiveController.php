<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\PurchaseOrder1;
use App\Models\Inventory\PurchaseOrder2;
use App\Models\Inventory\PurchaseReceive1;
use App\Models\Inventory\PurchaseReceive2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PagesHelp;
use HelpersInventory;


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
        $state = isset($request->state) ? $request->state :'open';

        $data=PurchaseReceive1::from('t_purchase_receive1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.invoice_number,a.partner_id,a.term_id,a.partner_name,a.total,a.due_date,a.location_id,b.location_name,
        a.item_group,c.descriptions as item_group_name,a.order_number,a.payable_number,is_void,void_date")
        ->leftjoin("m_warehouse as b","a.location_id","=","b.sysid")
        ->leftjoin("m_standard_code as c","a.item_group","=","c.standard_code")
        ->where('a.ref_date','>=',$date1)
        ->where('a.ref_date','<=',$date2);
        if ($state=='retur') {
            $data=$data->where('is_credit_notes','1');
        } else if ($state=='invoice') {
            $data=$data->where('is_credit_notes','0');
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.invoice_number', 'like', $filter);
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

        $receive=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($receive) {
            if ($receive->is_void=='1') {
                return response()->error('Gagal',501,'Dokumen penerimaan barang (invoice) sudah dibatalkan//void');
            } else if($receive->is_process=='1') {
                return response()->error('Gagal',501,'Dokumen penerimaan barang (invoice) tidak bisa divoid, sudah diproses pembayaran');
            }
        } else {
            return response()->error('',501,'Dokumen penerimaan barang (invoice) tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$receive->sysid;
            $receive->void_date=Date('Y-m-d H:i:s');
            $receive->void_by=PagesHelp::Users($request)->sysid;
            $receive->is_void='1';
            $receive->save();

            #revert purchase order document
            if ($receive->ref_document=='Penerimaan PO'){
                $lines=PurchaseReceive2::selectRaw("sysid,order_sysid,item_id,qty_received")->where('sysid',$receive->sysid)->get();
                foreach($lines as $line) {
                    DB::update("UPDATE t_purchase_order2 SET qty_received=qty_received - ?
                    WHERE sysid=? AND item_id=?",[$line->qty_received,$line->order_sysid,$line->item_id]);
                }
                DB::update("UPDATE t_purchase_order2 SET line_state='O'
                    WHERE sysid=? AND qty_received=0",[$receive->order_sysid]);

                $orders=PurchaseOrder2::selectRaw("line_state")->where('sysid',$receive->order_sysid)->get();
                $flag='OPEN';
                foreach($orders as $line) {
                    if ($line->line_state<>'O') {
                        $flag='PARTIAL';
                    }
                }
                DB::update("UPDATE t_purchase_order1 SET order_state=?
                    WHERE sysid=?",[$flag,$receive->order_sysid]);
            }
            $feedback=HelpersInventory::ItemCard($sysid,'PURCHASE','inserted','VOID');
            if ($feedback['success']==true) {
                DB::commit();
                return response()->success('Success','Pembatalan penerimaan barang (invoice) berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }
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
            'ref_time'=>'bail|required',
            'due_date'=>'bail|required',
            'location_id'=>'bail|required|exists:m_warehouse,sysid',
            'partner_id'=>'bail|required|exists:m_supplier,sysid'
        ],[
            'ref_date.required'=>'Tanggal peneirmaan harus diisi',
            'ref_time.required'=>'Jam penerimaan harus diisi',
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
            '*.qty_received.min'=>'Jumlah penerimaan harus diisi/lebih besar dari NOL',
            '*.price.min'=>'Harga pembelian tidak boleh NOL',
            '*.prc_discount1.min'=>'Diskon 1 tidak boleh lebih kecil dari NOL',
            '*.prc_discount1.max'=>'Diskon 1 tidak boleh lebih besar dari 100',
            '*.prc_discount2.min'=>'Diskon 2 tidak boleh lebih kecil dari NOL',
            '*.prc_discount2.max'=>'Diskon 2 tidak boleh lebih besar dari 100',
            '*.prc_tax.min'=>'PPN tidak boleh lebih kecil dari NOL',
            '*.prc_tax.max'=>'PPN tidak boleh lebih besar dari 100',
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
            if ($header['ref_document']=='Penerimaan PO') {
                if (floatval($line['qty_received']) > floatval($line['qty_order'])) {
                    return response()->error('Gagal',501,'Jumlah penerimaan tidak boleh lebih besar dari pemesanan');
                }
            }
        }

        DB::beginTransaction();
        try{
            $sysid_order=$header['order_sysid'];
            $partner=Supplier::select('supplier_name')->where('sysid',$header['partner_id'])->first();
            $receive=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($receive)) {
                $receive=new PurchaseReceive1();
                $receive->uuid_rec=Str::uuid();
                $receive->doc_number=PurchaseReceive1::GenerateNumber($header['ref_date']);
                $receive->create_by=PagesHelp::Users($request)->sysid;
                $operation='inserted';
            } else {
                if ($receive->is_process=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, Penerimaan sudah dibuatkan piutang - '.$receive->payable_number);
                } else if ($receive->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, Penerimaan sudah dibatalkan/void');
                }
                #revert purchase order document
                if ($receive->ref_document=='Penerimaan PO'){
                    $lines=PurchaseReceive2::selectRaw("sysid,order_sysid,item_id,qty_received")->where('sysid',$receive->sysid)->get();
                    foreach($lines as $line) {
                        DB::update("UPDATE t_purchase_order2 SET qty_received=qty_received - ?
                        WHERE sysid=? AND item_id=?",[$line->qty_received,$line->order_sysid,$line->item_id]);
                    }
                    DB::update("UPDATE t_purchase_order2 SET line_state='O'
                        WHERE sysid=? AND qty_received=0",[$receive->order_sysid]);

                    $orders=PurchaseOrder2::selectRaw("line_state")->where('sysid',$receive->order_sysid)->get();
                    $flag='OPEN';
                    foreach($orders as $line) {
                        if ($line->line_state<>'O') {
                            $flag='PARTIAL';
                        }
                    }
                    DB::update("UPDATE t_purchase_order1 SET order_state=?
                        WHERE sysid=?",[$flag,$receive->order_sysid]);
                }
                $receive->update_by=PagesHelp::Users($request)->sysid;
                PurchaseReceive2::where('sysid',$receive->sysid)->delete();
                $operation='updated';
            }
            $receive->ref_date=$header['ref_date'];
            $receive->ref_time=$header['ref_time'];
            $receive->invoice_number=isset($header['invoice_number']) ? $header['invoice_number'] :'';
            $receive->order_sysid=isset($header['order_sysid']) ? $header['order_sysid'] :'-1';
            $receive->order_number=isset($header['order_number']) ? $header['order_number'] :'-';
            $receive->ref_document=$header['ref_document'];
            $receive->due_date=$header['due_date'];
            $receive->location_id=$header['location_id'];
            $receive->partner_id=$header['partner_id'];
            $receive->partner_name=$partner->supplier_name;
            $receive->term_id=$header['term_id'];
            $receive->curr_rate=isset($header['curr_rate']) ? $header['curr_rate'] :'1';
            $receive->curr_code=isset($header['curr_code']) ? $header['curr_code'] :'IDR';
            $receive->amount=$header['amount'];
            $receive->discount1=$header['discount1'];
            $receive->discount2=$header['discount2'];
            $receive->tax=$header['tax'];
            $receive->total=$header['total'];
            $receive->is_tax=isset($header['is_tax']) ? $header['is_tax'] :'0';
            $receive->item_group=isset($header['item_group']) ? $header['item_group'] :'';
            $receive->save();
            $sysid=$receive->sysid;
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
                $line->order_sysid=$receive->order_sysid;
                $line->order_number=$receive->order_number;
                $line->qty_update=floatval($line->qty_received) * floatval($line->conversion);
                $line->cost_update=floatval($line->total)/floatval($line->qty_update);
                $line->save();
            }

            DB::update("UPDATE t_purchase_receive2 a INNER JOIN m_items b ON a.item_code=b.item_code
                SET a.item_id=b.sysid WHERE a.sysid=?",[$sysid]);

            #Update purchase order document
            if ($receive->ref_document=='Penerimaan PO'){
                $lines=PurchaseReceive2::selectRaw("sysid,order_sysid,item_id,qty_received")->where('sysid',$receive->sysid)->get();
                foreach($lines as $line) {
                    DB::update("UPDATE t_purchase_order2 SET qty_received=qty_received + ?,
                    received_sysid=?,received_number=?,received_date=? WHERE sysid=? AND item_id=?",
                    [$line->qty_received,$receive->sysid,$receive->doc_number,$receive->ref_date,$line->order_sysid,$line->item_id]);
                }
                DB::update("UPDATE t_purchase_order2 SET line_state='C'
                    WHERE sysid=? AND qty_order=qty_received",[$receive->order_sysid]);
                DB::update("UPDATE t_purchase_order2 SET line_state='P'
                    WHERE sysid=? AND qty_received<>0 AND qty_order<>qty_received",[$receive->order_sysid]);

                $orders=PurchaseOrder2::selectRaw("line_state")->where('sysid',$receive->order_sysid)->get();
                $flag='CLOSED';
                foreach($orders as $line) {
                    if ($line->line_state<>'C') {
                        $flag='PARTIAL';
                    }
                }
                DB::update("UPDATE t_purchase_order1 SET order_state=?
                    WHERE sysid=?",[$flag,$receive->order_sysid]);
            }

            $feedback=HelpersInventory::ItemCard($sysid,'PURCHASE',$operation,'IN');
            if ($feedback['success']==true) {
                DB::commit();
                return response()->success('Success','Simpan pembelian berhasil');
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
        $data['header']=PurchaseReceive1::where('uuid_rec',$uuidrec)->first();
        if ($data['header']) {
            $data['detail']=PurchaseReceive2::where('sysid',$data['header']->sysid)->get();
            if ($data['header']->is_credit_notes=='1') {
                $recs=array();
                foreach($data['detail'] as $row) {
                    $row->qty_received=abs($row->qty_received);
                    $row->prc_discount1=abs($row->prc_discount1);
                    $row->prc_discount2=abs($row->prc_discount1);
                    $row->prc_tax=abs($row->prc_tax);
                    $row->total=abs($row->total);
                    $recs[]=$row;
                }
                $data['detail']=$recs;
            }
        }
        return response()->success('Success', $data);
    }
    public function open(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $data=PurchaseReceive1::from('t_purchase_receive1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_date,a.invoice_number,a.partner_id,a.partner_name,a.total,a.expired_date,a.location_id,b.location_name,
        c.descriptions as purchase_type,d.descriptions as order_type,a.state,order_state,is_void,is_posted,posted_date,
        a.term_id,a.item_group")
        ->leftjoin("m_warehouse as b","a.location_id","=","b.sysid")
        ->leftjoin("m_standard_code as c","a.purchase_type","=","c.standard_code")
        ->leftjoin("m_standard_code as d","a.order_type","=","c.standard_code")
        ->where('a.is_process','0');
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.invoice_number', 'like', $filter);
                $q->orwhere('a.partner_name', 'like', $filter);
                $q->orwhere('b.location_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, $sorting)->paginate($limit);
        return response()->success('Success', $data);
    }

    public function detail(Request $request)
    {
        $uuidrec=isset($request->uuid_rec) ? $request->uuid_rec :'-';
        $data=PurchaseReceive1::from('t_purchase_receive1 as a')
        ->selectRaw("b.sysid,b.line_no,b.item_id,b.item_code,b.item_name,b.mou_purchase,b.conversion,b.mou_inventory,
        b.qty_order,b.qty_received,b.price,b.prc_discount1,b.prc_discount2,b.prc_tax")
        ->join('t_purchase_receive2 as b','a.sysid','=','b.sysid')
        ->where('a.uuid_rec',$uuidrec)
        ->where('a.is_credit_notes','0')
        ->get();
        return response()->success('Success', $data);
    }

    public function destroy_credit(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];

        $receive=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($receive) {
            if ($receive->is_void=='1') {
                return response()->error('Gagal',501,'Dokumen retur penerimaan barang (invoice) sudah dibatalkan/void');
            } else if($receive->is_process=='1') {
                return response()->error('Gagal',501,'Dokumen retur penerimaan barang (invoice) tidak bisa divoid, sudah diproses pembayaran');
            }
        } else {
            return response()->error('',501,'Dokumen retur penerimaan barang (invoice) tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$receive->sysid;
            $receive->void_date=Date('Y-m-d H:i:s');
            $receive->void_by=PagesHelp::Users($request)->sysid;
            $receive->is_void='1';
            $receive->save();

            #revert purchase order document
            if ($receive->ref_document=='Retur Pembelian'){
                $lines=PurchaseReceive2::selectRaw("sysid,order_sysid,item_id,ABS(qty_received) as qty_received")->where('sysid',$receive->sysid)->get();
                foreach($lines as $line) {
                    DB::update("UPDATE t_purchase_receive2 SET qty_received=qty_received - ?
                    WHERE sysid=? AND item_id=?",[$line->qty_received,$line->order_sysid,$line->item_id]);
                }
            }
            $feedback=HelpersInventory::ItemCard($sysid,'PURCHASE-RETURN','inserted','VOID');
            if ($feedback['success']==true) {
                DB::commit();
                return response()->success('Success','Pembatalan retur penerimaan barang (invoice) berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function store_credit(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $detail=$data['detail'];
        $validator=Validator::make($header,[
            'ref_date'=>'bail|required|date',
            'ref_time'=>'bail|required',
            'due_date'=>'bail|required',
            'location_id'=>'bail|required|exists:m_warehouse,sysid',
            'partner_id'=>'bail|required|exists:m_supplier,sysid'
        ],[
            'ref_date.required'=>'Tanggal peneirmaan harus diisi',
            'ref_time.required'=>'Jam penerimaan harus diisi',
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
            '*.qty_received.min'=>'Jumlah retur harus diisi/lebih besar dari NOL',
            '*.price.min'=>'Harga pembelian tidak boleh NOL',
            '*.prc_discount1.min'=>'Diskon 1 tidak boleh lebih kecil dari NOL',
            '*.prc_discount1.max'=>'Diskon 1 tidak boleh lebih besar dari 100',
            '*.prc_discount2.min'=>'Diskon 2 tidak boleh lebih kecil dari NOL',
            '*.prc_discount2.max'=>'Diskon 2 tidak boleh lebih besar dari 100',
            '*.prc_tax.min'=>'PPN tidak boleh lebih kecil dari NOL',
            '*.prc_tax.max'=>'PPN tidak boleh lebih besar dari 100',
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
            if ($header['ref_document']=='Retur Pembelian') {
                if (floatval($line['qty_received']) > floatval($line['qty_order'])) {
                    return response()->error('Gagal',501,'Jumlah retur tidak boleh lebih besar dari penerimaan');
                }
            }
        }

        DB::beginTransaction();
        try{
            $sysid_order=$header['order_sysid'];
            $partner=Supplier::select('supplier_name')->where('sysid',$header['partner_id'])->first();
            $receive=PurchaseReceive1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($receive)) {
                $receive=new PurchaseReceive1();
                $receive->uuid_rec=Str::uuid();
                $receive->doc_number=PurchaseReceive1::GenerateNumberCN($header['ref_date']);
                $receive->create_by=PagesHelp::Users($request)->sysid;
                $operation='inserted';
            } else {
                if ($receive->is_process=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, retur penerimaan sudah dibuatkan piutang - '.$receive->payable_number);
                } else if ($receive->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, retur penerimaan sudah dibatalkan/void');
                }
                #revert invoice receive
                if ($receive->ref_document=='Retur Pembelian'){
                    $lines=PurchaseReceive2::selectRaw("sysid,order_sysid,item_id,ABS(qty_received) as qty_received")->where('sysid',$receive->sysid)->get();
                    foreach($lines as $line) {
                        DB::update("UPDATE t_purchase_receive2 SET qty_return=qty_return - ?
                        WHERE sysid=? AND item_id=?",[$line->qty_received,$line->order_sysid,$line->item_id]);
                    }
                }
                $receive->update_by=PagesHelp::Users($request)->sysid;
                PurchaseReceive2::where('sysid',$receive->sysid)->delete();
                $operation='updated';
            }
            $receive->ref_date = $header['ref_date'];
            $receive->ref_time = $header['ref_time'];
            $receive->invoice_number = isset($header['invoice_number']) ? $header['invoice_number'] :'';
            $receive->order_sysid = isset($header['order_sysid']) ? $header['order_sysid'] :'-1';
            $receive->order_number = isset($header['order_number']) ? $header['order_number'] :'-';
            $receive->ref_document = $header['ref_document'];
            $receive->due_date = $header['due_date'];
            $receive->location_id = $header['location_id'];
            $receive->partner_id = $header['partner_id'];
            $receive->partner_name = $partner->supplier_name;
            $receive->term_id = $header['term_id'];
            $receive->curr_rate = isset($header['curr_rate']) ? $header['curr_rate'] :'1';
            $receive->curr_code = isset($header['curr_code']) ? $header['curr_code'] :'IDR';
            $receive->amount = -$header['amount'];
            $receive->discount1 = -$header['discount1'];
            $receive->discount2 = -$header['discount2'];
            $receive->tax = -$header['tax'];
            $receive->total = -$header['total'];
            $receive->is_credit_notes = '1';
            $receive->is_tax = isset($header['is_tax']) ? $header['is_tax'] :'0';
            $receive->item_group = isset($header['item_group']) ? $header['item_group'] :'';
            $receive->save();
            $sysid=$receive->sysid;
            foreach($detail as $rec) {
                $line= new PurchaseReceive2();
                $line->sysid = $sysid;
                $line->line_no = $rec['line_no'];
                $line->item_code = $rec['item_code'];
                $line->item_name = $rec['item_name'];
                $line->mou_purchase = $rec['mou_purchase'];
                $line->conversion = $rec['conversion'];
                $line->mou_inventory = $rec['mou_inventory'];
                $line->price = $rec['price'];
                $line->qty_received = - $rec['qty_received'];
                $line->qty_order = $rec['qty_order'];
                $line->prc_discount1 = $rec['prc_discount1'];
                $line->discount1 = - $rec['discount1'];
                $line->prc_discount2 = $rec['prc_discount2'];
                $line->discount2 = - $rec['discount2'];
                $line->prc_tax = - $rec['prc_tax'];
                $line->tax = - $rec['tax'];
                $line->total = - $rec['total'];
                $line->order_sysid = $receive->order_sysid;
                $line->order_number = $receive->order_number;
                $line->qty_update = floatval($line->qty_received) * floatval($line->conversion);
                $line->cost_update = floatval($line->total)/floatval($line->qty_update);
                $line->save();
            }

            DB::update("UPDATE t_purchase_receive2 a INNER JOIN m_items b ON a.item_code=b.item_code
                SET a.item_id=b.sysid WHERE a.sysid=?",[$sysid]);

            #Update purchase order document
            if ($receive->ref_document=='Retur Pembelian'){
                $lines=PurchaseReceive2::selectRaw("sysid,order_sysid,item_id,ABS(qty_received) as qty_received")->where('sysid',$receive->sysid)->get();
                foreach($lines as $line) {
                    DB::update("UPDATE t_purchase_receive2 SET qty_received=qty_received + ?
                    WHERE sysid=? AND item_id=?",
                    [$line->qty_received,$line->order_sysid,$line->item_id]);
                }
            }

            $feedback=HelpersInventory::ItemCard($sysid,'PURCHASE-RETURN',$operation,'OUT');
            if ($feedback['success']==true) {
                DB::commit();
                return response()->success('Success','Simpan retur pembelian berhasil');
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
