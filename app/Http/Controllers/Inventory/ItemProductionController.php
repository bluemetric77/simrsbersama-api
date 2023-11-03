<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\ItemProduction1;
use App\Models\Inventory\ItemProduction2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Warehouse;
use App\Models\Master\Inventory\BillOfMaterial;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PagesHelp;
use HelpersInventory;
use DataLog;


class ItemProductionController extends Controller
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
        $data=ItemProduction1::from('t_items_production1 as a')
        ->selectRaw("a.uuid_rec,a.sysid,a.doc_number,a.ref_number,a.ref_date,a.ref_time,a.ref_number,a.location_id,a.location_name,
        a.cost_standard,a.cost_production,a.item_code,a.item_name,a.output_standard,a.output_planning")
        ->where('a.ref_date','>=',$date1)
        ->where('a.ref_date','<=',$date2);
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
        $prd1=ItemProduction1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
        if ($prd1) {
            if ($prd1->is_void=='1') {
                DB::rollback();
                return response()->error('Gagal',501,'Data tidak bisa diupdate, produksi sudah dibatalkan');
            } else if ($prd1->cost_item>0) {
                DB::rollback();
                return response()->error('Gagal',501,'Data tidak bisa diupdate, proses produksi sudah selesai');
            }
        } else {
            return response()->error('',501,'Data pengeluaran bahan baku/material produksi tidak ditemukan');
        }

        DB::beginTransaction();
        try{
            $sysid=$prd1->sysid;
            $prd1->void_date=Date('Y-m-d H:i:s');
            $prd1->void_by=PagesHelp::Users($request)->sysid;
            $prd1->is_void='1';
            $prd1->save();
            $feedback=HelpersInventory::ItemCard($sysid,'BOM-PRODUCTION','updated','VOID');
            if ($feedback['success']==true) {
                $old['header']=ItemProduction1::where('sysid',$sysid)->first();
                $old['detail']=ItemProduction2::where('sysid',$sysid)->get();
                DataLog::create($sysid,$prd1->documentid,$prd1->sysid,$prd1->doc_number,'BOM-PRODUCTION','DELETED',$old,array());
                DB::commit();
                return response()->success('Success','Pembatalan dokumen produksi berhasil');
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
            'location_id'=>'bail|required|exists:m_warehouse,sysid',
            'item_code'=>'bail|required|exists:m_items,item_code',
            'output_standard'=>'bail|required|numeric|min:1',
            'output_planning'=>'bail|required|numeric|min:1',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id.required'=>'Lokasi harus diisi',
            'location_id.exists'=>'Lokasi tidak ditemukan dimaster',
            'item_code.required'=>'Item produksi harus diisi',
            'item_code.exists'=>'Item Produksi tidak ditemukan di master',
            'output_standard.min'=>'Jumlah standar produksi harus lebih besar dari NOL',
            'output_planning.min'=>'Jumlah rencana produksi harus lebih besar dari NOL',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|distinct|exists:m_items,item_code',
            '*.mou_inventory'=>'bail|required',
            '*.quantity_item'=>'bail|required|numeric|min:1',
            '*.item_cost'=>'bail|required|numeric|min:1',
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.mou_inventory.required'=>'Satuan Permintaan harus diisi',
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
            $prd1=ItemProduction1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($prd1)) {
                $prd1=new ItemProduction1();
                $prd1->uuid_rec=Str::uuid();
                $prd1->documentid=8005;
                $prd1->doc_number= ItemProduction1::GenerateNumber($header['ref_date']) ;
                $prd1->create_by = PagesHelp::Users($request)->sysid;

                $old['header']=null;
                $old['detail']=array();

                $operation='inserted';
            } else {
                if ($prd1->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, produksi sudah dibatalkan');
                } else if ($prd1->cost_item>0) {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, proses produksi sudah selesai');
                }

                #Get old document and rollback document inventory request
                $old['header']=ItemProduction1::where('sysid',$prd1->sysid)->first();
                $old['detail']=ItemProduction2::where('sysid',$prd1->sysid)->get();

                #Deleted old document_distribustion
                ItemProduction2::where('sysid',$prd1->sysid)->delete();

                $operation='updated';

                $prd1->update_by = PagesHelp::Users($request)->sysid;
            }
            $prd1->ref_number = isset($header['ref_number']) ? $header['ref_number'] :'';
            $prd1->ref_date  = $header['ref_date'];
            $prd1->ref_time  = $header['ref_time'];
            $prd1->location_id   = $header['location_id'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$prd1->location_id)->first();
            $prd1->location_name = isset($warehouse->location_name) ? $warehouse->location_name :'';
            $prd1->item_sysid    = $header['item_sysid'];
            $prd1->item_code    = $header['item_code'];
            $prd1->item_name    = $header['item_name'];
            $prd1->mou_inventory    = $header['mou_inventory'];
            $prd1->output_standard  = $header['output_standard'];
            $prd1->output_planning  = $header['output_planning'];
            $prd1->item_group    = $header['item_group'];
            $prd1->remarks       = isset($header['remarks']) ? $header['remarks'] :'';
            $prd1->save();

            $sysid = $prd1->sysid;
            $cost  = 0;
            foreach($detail as $rec) {
                $line= new ItemProduction2();
                $line->sysid      = $sysid;
                $line->line_no    = $rec['line_no'];
                $line->item_sysid = $rec['item_sysid'];
                $line->item_code  = $rec['item_code'];
                $line->item_name  = $rec['item_name'];
                $line->mou_inventory = $rec['mou_inventory'];
                $line->quantity_standard = $rec['quantity_standard'];
                $line->quantity_item = $rec['quantity_item'];
                $line->item_cost  = $rec['item_cost'];
                $line->line_cost  = $rec['line_cost'];
                $line->quantity_update = $rec['quantity_item'];
                $line->remarks    = isset($rec['remarks']) ? $rec['remarks'] :'';
                $line->account_cost      = isset($rec['account_cost']) ? $rec['account_cost'] :'';
                $line->account_inventory = isset($rec['account_inventory']) ? $rec['account_inventory'] :'';
                $line->save();

                #Calculate Cost and update Inventory request
                $cost=$cost + $line->line_cost;
            }

            $prd1->cost_standard=$cost;
            $prd1->cost_production=$cost;
            $prd1->save();
            $feedback=HelpersInventory::ItemCard($sysid,'BOM-PRODUCTION',$operation,'OUT');

            if ($feedback['success']==true) {
                $new['header'] = ItemProduction1::where('sysid',$prd1->sysid)->first();
                $new['detail'] = ItemProduction2::where('sysid',$prd1->sysid)->get();
                DataLog::create($sysid,$prd1->documentid,$prd1->sysid,$prd1->doc_number,'BOM-PRODUCTION',($operation=='inserted') ?'CREATED':'UPDATED',$old,$new);
                DB::commit();
                return response()->success('Success','Pengeluaran bahan/material produksi berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function store_result(Request $request) {
        $data= $request->json()->all();
        $header=$data['data'];
        $validator=Validator::make($header,[
            'production_date'=>'bail|required',
            'production_time'=>'bail|required',
            'output_production'=>'bail|required|numeric|min:1',
        ],[
            'production_date.required'=>'Tanggal harus diisi',
            'production_time.required'=>'Lokasi harus diisi',
            'output_production.min'=>'Jumlah standar produksi harus lebih besar dari NOL',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $prd1=ItemProduction1::where('uuid_rec',isset($header['uuid_rec']) ? $header['uuid_rec'] :'')->first();
            if (!($prd1)) {
                DB::rollback();
                return response()->error('Gagal',501,'Data produksi tidak ditemukan');
            } else {
                if ($prd1->is_void=='1') {
                    DB::rollback();
                    return response()->error('Gagal',501,'Data tidak bisa diupdate, produksi sudah dibatalkan');
                }
            }
            if ($prd1->production_create_date==null) {
                $operation='inserted';
            } else {
                $operation='updated';
            }
            $prd1->production_by = PagesHelp::Users($request)->sysid;
            $prd1->production_create_date = Date('Y-m-d H:i:s');
            $prd1->production_date    = $header['production_date'];
            $prd1->production_time    = $header['production_time'];
            $prd1->output_production  = $header['output_production'];
            if ($prd1->output_production==0) {
                $prd1->cost_item = 0;
            } else {
               $prd1->cost_item  = $prd1->cost_standard/$prd1->output_production;
            }
            $prd1->cost_production = $prd1->cost_item * $prd1->output_production;
            $prd1->save();
            $feedback=HelpersInventory::ItemCard($prd1->sysid,'PRODUCTION',$operation,'IN');

            if ($feedback['success']==true) {
                $old = array();
                $new = ItemProduction1::where('sysid',$prd1->sysid)->first();
                DataLog::create(-1,$prd1->documentid,$prd1->sysid,$prd1->doc_number,'PRODUCTION',($operation=='inserted') ? 'CREATED' :'UPDATED',$old,$new);
                DB::commit();
                return response()->success('Success','Simpan hasil produksi berhasil');
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
        $data['header']=ItemProduction1::where('uuid_rec',$uuidrec)->first();
        $data['detail']=ItemProduction2::where('sysid',isset($data['header']->sysid) ? $data['header']->sysid :-1)->get();
        return response()->success('Success', $data);
    }

    public function get_item_production(Request $request) {
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $location=isset($request->location_id) ? $request->location_id :'-1';
        $data['item']=Inventory::selectRaw("sysid,item_code,item_name1,quantity_production")->where('sysid',$sysid)->first();
        $data['bom']=BillOfMaterial::from("m_items_bom as bom")
        ->selectRaw("bom.line_no,bom.bom_sysid,bom.item_code,bom.item_name,bom.quantity_bom,bom.mou_inventory,IFNULL(ims.cogs,0) as cogs")
        ->join("m_items_stock as ims",function($join) use($location) {
            $join->on("bom.bom_sysid","=","ims.item_sysid");
            $join->on("ims.location_id","=",DB::raw("$location"));
        })
        ->where("bom.item_sysid",$sysid)->get();
        return response()->success('Success', $data);
    }
}
