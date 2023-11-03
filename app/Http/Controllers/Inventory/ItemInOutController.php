<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\ItemInOut1;
use App\Models\Inventory\ItemInOut2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Warehouse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PagesHelp;
use HelpersInventory;
use DataLog;


class ItemInOutController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 50;
        $sorting = ($request->descending == "true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1 :'1899-01-01';
        $date2 = isset($request->date2) ? $request->date2 :'1899-01-01';
        $line_type = isset($request->line_type) ? $request->line_type :'OUT';
        $data=ItemInOut1::from('t_items_inout1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_number,a.ref_date,a.ref_time,a.ref_number,a.location_id,a.location_name,
        a.registration_sysid,a.registration_number,a.patient_name,a.cost")
        ->where('a.ref_date','>=',$date1)
        ->where('a.ref_date','<=',$date2)
        ->where('a.line_type',$line_type);
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.ref_number', 'like', $filter);
                $q->orwhere('a.location_name', 'like', $filter);
                $q->orwhere('a.patient_name', 'like', $filter);
                $q->orwhere('a.registration_number', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, $sorting)->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request) {
        $data= $request->json()->all();
        $header=$data['header'];
        $inout=ItemInOut1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($inout) {
            if ($inout->is_void=='1') {
                return response()->error('Gagal',501,'pengeluaran/penerimaan barang sudah dibatalkan');
            }
        } else {
            return response()->error('',501,'Data pengeluaran/penerimaan barang tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$inout->sysid;
            $inout->void_date=Date('Y-m-d H:i:s');
            $inout->void_by=PagesHelp::Users($request)->sysid;
            $inout->is_void='1';
            $inout->save();
            $feedback=HelpersInventory::ItemCard($sysid,($inout->line_type=='IN') ? 'INVENTORY-IN':'INVENTORY-OUT','inserted','VOID');

            if ($feedback['success']==true) {
                $old['header']=ItemInOut1::where('sysid',$sysid)->first();
                $old['detail']=ItemInOut2::where('sysid',$sysid)->get();
                DataLog::create($sysid,$inout->documentid,$inout->sysid,$inout->doc_number,($inout->line_type=='IN') ? 'INVENTORY-IN':'INVENTORY-OUT','DELETED',$old,"-");
                DB::commit();
                return response()->success('Success',($inout->line_type=='IN') ? 'Pembatalan penerimaan barang berhasil':'Pembatalan pengeluaran barang berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['info']);
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
            'location_id'=>'bail|required|exists:m_warehouse,sysid',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id.required'=>'Lokasi harus diisi',
            'location_id.exists'=>'Lokasi tidak ditemukan dimaster',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_issue'=>'bail|required',
            '*.quantity_item'=>'bail|required|numeric|min:1',
            '*.item_cost'=>'bail|required|numeric|min:1',
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.mou_issue.required'=>'Satuan Permintaan harus diisi',
            '*.quantity_item.min'=>'Jumlah distribusi harus diisi/lebih besar dari NOL',
            '*.item_code.distinct'=>'Kode barang :input terduplikasi (terinput lebih dari 1)',
            '*.item_cost.required'=>'Harga item harus diisi',
            '*.item_cost.min'=>'Jumlah item harus diisi/lebih besar dari NOL',
        ]);

        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            $inout=ItemInOut1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($inout)) {
                $inout=new ItemInOut1();
                $inout->uuid_rec=Str::uuid();
                $inout->documentid=($header['line_type']=='OUT') ? 8003 : 8004;
                $inout->doc_number= ($header['line_type']=='IN') ? ItemInOut1::GenerateNumberIN($header['ref_date']) : ItemInOut1::GenerateNumberOUT($header['ref_date']);
                $inout->create_by = PagesHelp::Users($request)->sysid;
                $inout->line_type = $header['line_type'];

                $old['header']=null;
                $old['detail']=array();

                $operation='inserted';
            } else {
                if ($inout->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, distribusi sudah dibatalkan');
                }

                #Get old document and rollback document inventory request
                $old['header']=ItemInOut1::where('sysid',$inout->sysid)->first();
                $old['detail']=ItemInOut2::where('sysid',$inout->sysid)->get();

                #Deleted old document_distribustion
                ItemInOut2::where('sysid',$inout->sysid)->delete();

                $operation='updated';

                $inout->update_by = PagesHelp::Users($request)->sysid;
            }
            $inout->ref_date  = $header['ref_date'];
            $inout->ref_time  = $header['ref_time'];
            $inout->registration_sysid  = isset($header['registration_sysid']) ? $header['registration_sysid'] :'-1';
            $inout->registration_number = isset($header['registration_number']) ? $header['registration_number'] :'';
            $inout->patient_name        = isset($header['patient_name']) ? $header['patient_name'] :'';
            $inout->location_id   = $header['location_id'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$inout->location_id)->first();
            $inout->location_name = isset($warehouse->location_name) ? $warehouse->location_name :'';
            $inout->remarks       = isset($header['remarks']) ? $header['remarks'] :'';
            $inout->save();

            $sysid = $inout->sysid;
            $cost  = 0;
            foreach($detail as $rec) {
                $line= new ItemInOut2();
                $line->sysid      = $sysid;
                $line->line_no    = $rec['line_no'];
                $line->item_sysid = -1;
                $line->item_code  = $rec['item_code'];
                $line->item_name  = $rec['item_name'];
                $line->mou_issue  = $rec['mou_issue'];
                $line->convertion = $rec['convertion'];
                $line->mou_inventory = $rec['mou_inventory'];
                $line->quantity_item = $rec['quantity_item'];
                $line->item_cost  = $rec['item_cost'];
                $line->line_cost  = $rec['line_cost'];
                $line->quantity_update = $rec['quantity_update'];
                $line->remarks    = isset($rec['remarks']) ? $rec['remarks'] :'';
                $line->account_cost      = isset($rec['account_cost']) ? $rec['account_cost'] :'';
                $line->account_inventory = isset($rec['account_inventory']) ? $rec['account_inventory'] :'';
                $line->save();

                #Calculate Cost and update Inventory request
                $cost=$cost + $line->line_cost;
            }

            $inout->cost=$cost;
            $inout->save();

            DB::UPDATE("UPDATE t_items_inout2 a INNER JOIN m_items b ON a.item_code=b.item_code
            SET a.item_sysid=b.sysid WHERE a.sysid=?",[$inout->sysid]);

            $feedback=HelpersInventory::ItemCard($sysid,($inout->line_type=='IN') ? 'INVENTORY-IN':'INVENTORY-OUT',$operation,$inout->line_type);

            if ($feedback['success']==true) {
                $new['header'] = ItemInOut1::where('sysid',$inout->sysid)->first();
                $new['detail'] = ItemInOut2::where('sysid',$inout->sysid)->get();
                DataLog::create($sysid,$inout->documentid,$inout->sysid,$inout->doc_number,($inout->line_type=='IN') ? 'INVENTORY-IN':'INVENTORY-OUT',($operation=='inserted') ?'CREATED':'UPDATED',$old,$new);
                DB::commit();
                return response()->success('Success',($inout->line_type=='IN') ? 'Penerimaan barang berhasil':'Pengeluaran barang berhasil');
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
        $data['header']=ItemInOut1::where('uuid_rec',$uuidrec)->first();
        $data['detail']=ItemInOut2::where('sysid',isset($data['header']->sysid) ? $data['header']->sysid :-1)->get();
        return response()->success('Success', $data);
    }
}
