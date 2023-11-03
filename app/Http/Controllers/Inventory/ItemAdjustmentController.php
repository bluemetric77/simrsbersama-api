<?php

namespace App\Http\Controllers\Inventory;

use App\Master\Partner;
use App\Models\Inventory\ItemsAdjustment1;
use App\Models\Inventory\ItemsAdjustment2;
use App\Models\Master\Inventory\Inventory;
use App\Models\Master\Inventory\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PagesHelp;
use HelpersInventory;
use DataLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use PDF;

class ItemAdjustmentController extends Controller
{
    public function index(Request $request){
        $filter = $request->filter;
        $limit = $request->limit;
        $sorting = ($request->descending=="true") ?"desc" :"asc";
        $sortBy = $request->sortBy;
        $date1 = $request->date1;
        $date2 = $request->date2;
        $data= ItemsAdjustment1::SelectRaw("sysid,doc_number,reference,location_name,ref_date,ref_time,notes,adjustment_cost,uuid_rec");
        $data=$data
           ->where('ref_date','>=',$date1)
           ->where('ref_date','<=',$date2);
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where(function($q) use ($filter) {
                    $q->where('doc_number','like',$filter);
            });
        }
        $data=$data->orderBy($sortBy,$sorting)->paginate($limit);
        return response()->success('Success',$data);
    }
    public function get(Request $request){
        $uuidrec=$request->uuidrec;
        $header=ItemsAdjustment1::SelectRaw("sysid,doc_number,location_id,location_name,reference,ref_date,ref_time,
        snapshoot_id,item_group,adjustment_cost,document_type,notes")
        ->where('uuid_rec',$uuidrec)->first();
        if ($header) {
            $data['header']=$header;
            $data['detail']=ItemsAdjustment2::from('t_items_adjustment2 as a')
            ->select('a.sysid','a.line_no','a.item_sysid','a.item_code','a.item_name','a.mou_inventory',
             'a.current_stock','a.opname_stock','a.adjustment_stock','a.end_stock','a.cost_current','a.cost_adjustment','a.final_adjustment',
             'a.notes')
            ->where('a.sysid',$header->sysid)->get();
            return response()->success('Success',$data);
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }
    public function store(Request $request){
        $data= $request->json()->all();
        $header  = $data['header'];
        $detail  = $data['detail'];

        $validator=Validator::make($header,[
            'ref_date'=>'bail|required',
            'location_id'=>'bail|required',
        ],[
            'ref_date.required'=>'Tanggal harus diisi',
            'location_id.required'=>'Lokasi/gudang harus diisi',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->all());
        }

        $validator=Validator::make($detail,[
            '*.item_code'=>'bail|required|exists:m_items,item_code',
            '*.opname_stock'=>'bail|required|numeric|min:0',
            '*.cost_adjustment'=>'bail|required|numeric|min:1'
        ],[
            '*.item_code.required'=>'Kode barang harus diisi',
            '*.item_code.exists'=>'Kode barang :input tidak ditemukan dimaster',
            '*.opname_stock.min'=>'Jumlah opname harus diisi/lebih besar dari NOL',
            '*.cost_adjustment.min'=>'Harga inventory tidak boleh NOL',
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            $adjustment1=ItemsAdjustment1::where("uuid_rec",$header['uuid_rec'])->first();
            if ($adjustment1==null) {
                $adjustment1=new ItemsAdjustment1();
                $adjustment1->uuid_rec=Str::uuid();
                $adjustment1->documentid=8005;
                $adjustment1->doc_number=ItemsAdjustment1::GenerateNumber($header['ref_date']);
                $adjustment1->create_by=PagesHelp::Users($request)->sysid;
            } else {
                DB::rollback();
                return response()->error('',501,'Koreksi stock tidak bisa diedit/ubah');
            }
            $adjustment1->reference    = isset($header['reference']) ? $header['reference'] :'';
            $adjustment1->ref_date     = $header['ref_date'];
            $adjustment1->ref_time     = $header['ref_time'];
            $adjustment1->item_group   = $header['item_group'];
            $adjustment1->adjustment_cost  = $header['adjustment_cost'];
            $adjustment1->document_type= $header['document_type'];
            $adjustment1->notes        = $header['notes'];
            $adjustment1->location_id  = $header['location_id'];
            $warehouse=Warehouse::selectRaw("location_name")->where('sysid',$adjustment1->location_id)->first();
            $adjustment1->location_name = isset($warehouse->location_name) ? $warehouse->location_name :'';
            $adjustment1->save();
            $adjustment1->refresh();
            $sysid=$adjustment1->sysid;

            foreach($detail as $rec) {
                $dtl = new ItemsAdjustment2();
                $dtl->sysid=$sysid;
                $dtl->line_no     = $rec['line_no'];
                $dtl->item_sysid  = $rec['item_sysid'];
                $dtl->item_code   = $rec['item_code'];
                $dtl->item_name   = $rec['item_name'];
                $dtl->mou_inventory    = $rec['mou_inventory'];
                $dtl->freeze_stock     = isset($rec['freeze_stock']) ? $rec['freeze_stock'] :0;
                $dtl->movement_stock   = isset($rec['movement_stock']) ? $rec['movement_stock'] :0;
                $dtl->final_stock      = isset($rec['final_stock']) ? $rec['final_stock'] :0;
                $dtl->current_stock    = $rec['current_stock'];
                $dtl->opname_stock     = $rec['opname_stock'];
                $dtl->adjustment_stock = $rec['adjustment_stock'];
                $dtl->end_stock        = $rec['end_stock'];
                $dtl->cost_current     = $rec['cost_current'];
                $dtl->cost_adjustment  = $rec['cost_adjustment'];
                $dtl->final_adjustment = $rec['final_adjustment'];
                $dtl->location_id      = $adjustment1->location_id;
                $dtl->snapshoot_id     = $adjustment1->snapshoot_id;
                $dtl->notes            = $rec['notes'];
                $dtl->save();
            }

            $feedback=HelpersInventory::ItemCard($sysid,'STOCK-ADJ','inserted','SO');

            if ($feedback['success']==true) {
                $new['header'] = ItemsAdjustment1::where('sysid',$adjustment1->sysid)->first();
                $new['detail'] = ItemsAdjustment2::where('sysid',$adjustment1->sysid)->get();
                DataLog::create(-1,$adjustment1->documentid,$adjustment1->sysid,$adjustment1->doc_number,'STOCK-OPNAME','',array(),$new);
                DB::commit();
                return response()->success('Success','Stock opname berhasil');
            } else {
                DB::rollback();
                return response()->error('',501,$feedback['message']);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }
    public function print(Request $request){
        $sysid=$request->sysid;
        $header=ItemsAdjustment1::from('t_inventory_correction1 as a')
        ->select('a.doc_number','a.ref_date','a.site_code','a.wh_code',
                DB::raw('b.descriptions as warehouse_name'),DB::raw('c.descriptions as pool_name'),'a.update_userid','a.update_timestamp',
                'd.line_no','d.item_code','d.descriptions','d.current_stock','d.opname_stock','d.cost_adjustment','d.end_stock','d.mou_inventory',
                'e.user_name')
        ->leftJoin('m_warehouse as b','a.wh_code','=','b.wh_code')
        ->leftJoin('m_pool as c','a.site_code','=','c.site_code')
        ->leftJoin('t_inventory_correction2 as d','a.sysid','=','d.sysid')
        ->leftJoin('o_users as e','a.update_userid','=','e.user_id')
        ->where('a.sysid',$sysid)->get();
        if (!$header->isEmpty()) {
            $header[0]->ref_date=date_format(date_create($header[0]->ref_date),'d-m-Y');
            $profile=PagesHelp::Profile();
            $pdf = PDF::loadView('inventory.StockOpname',['header'=>$header,'profile'=>$profile])->setPaper('A4','potriat');
            return $pdf->stream();
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }
}
