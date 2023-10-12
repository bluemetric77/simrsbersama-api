<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PagesHelp;
use DataLog;


class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $group_name=isset($request->group_name) ? $request->group_name : 'MEDICAL';
        $is_active=isset($request->is_active) ? $request->is_active : false;
        $is_all=isset($request->all) ? $request->all : '0';
        if ($is_active==true) {
            $data=Warehouse::selectRaw("sysid,location_code,location_name,warehouse_group,is_received,is_sales,is_distribution,uuid_rec");
            if ($is_all=='0') {
                $data=$data->where('warehouse_group',$group_name);
            }
            $data=$data->where('is_active',true);
        } else {
            $data=Warehouse::selectRaw("sysid,location_code,location_name,warehouse_group,inventory_account,cogs_account,expense_account,variant_account,
            warehouse_type,is_received,is_sales,is_distribution,is_active,update_userid,create_date,update_date,uuid_rec")
            ->where('warehouse_group',$group_name);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('location_code', 'like', $filter);
                $q->orwhere('location_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $uuid_rec=isset($request->uuid_rec) ? $request->uuid_rec :'';
        $data=Warehouse::where('uuid_rec',$uuid_rec)->first();
        if ($data) {
            DB::beginTransaction();
            try{
                $old = Warehouse::where('uuid_rec',$uuid_rec)->first();
                DataLog::create($sysid,8000,$data->sysid,$data->location_code,'WAREHOUSE','DELETED',$old,"-");
                Warehouse::where('uuid_rec',$uuid_rec)->delete();
                DB::commit();
                return response()->success('Success','Hapus data berhasil');
            }
            catch(\Exception $e) {
                DB::rollback();
                return response()->error('',501,$e);
            }
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function edit(Request $request){
        $uuid_rec=isset($request->uuid_rec) ? $request->uuid_rec :'';
        $data=Warehouse::selectRaw("sysid,location_code,location_name,inventory_account,cogs_account,expense_account,variant_account,
            warehouse_type,is_received,is_sales,is_distribution,is_active")
        ->where('uuid_rec',$uuid_rec)->first();
        return response()->success('Success',$data);
    }

    public function getlist(Request $request){
        $type=isset($request->type) ? $request->type :'ALL';
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Warehouse::selectRaw("sysid,location_code,location_name")
        ->where('is_active','1');
        if ($type=='SALES') {
            $data=$data->where('is_sales','1');
        } else if ($type=='RECEIVE') {
            $data=$data->where('is_received','1');
        } else if ($type=='DISTRIBUSTION') {
            $data=$data->where('is_distribution','1');
        } else if ($type=='PRODUCTION') {
            $data=$data->where('is_sales','1');
        }
        $data=$data->orderBy('location_name')
        ->get();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'location_code'=>'bail|required',
            'location_name'=>'bail|required',
        ],[
            'location_code.required'=>'Kode gudang diisi',
            'location_name.required'=>'Nama gudang diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Warehouse();
                $data->uuid_rec=Str::uuid();
                $data->warehouse_group=$row['warehouse_group'];
                $operation='CREATED';
                $old  = "-";
            } else if ($opr=='updated'){
                $data = Warehouse::where('uuid_re',$row['uuid_rec'])->first();
                $old  = $data;
                $operation='UPDATED';

            }
            $data->location_code  = $row['location_code'];
            $data->location_name  = $row['location_name'];
            $data->inventory_account = $row['inventory_account'];
            $data->cogs_account   = $row['cogs_account'];
            $data->expense_account= $row['expense_account'];
            $data->variant_account= $row['variant_account'];
            $data->warehouse_type = $row['warehouse_type'];
            $data->is_received    = $row['is_received'];
            $data->is_sales       = $row['is_sales'];
            $data->is_distribution= $row['is_distribution'];
            $data->is_active      = $row['is_active'];
            $data->update_userid  = PagesHelp::UserID($request);
            $data->save();
            $data->refresh();
            $new = $data;
            DataLog::create($sysid,8000,$data->sysid,$data->location_code,'WAREHOUSE',$operation,$old,$old);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();
        }
    }
}
