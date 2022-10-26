<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

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
        if ($is_active==true) {
            $data=Warehouse::selectRaw("sysid,loc_code,location_name,is_received,is_sales,is_distribution")
            ->where('warehouse_group',$group_name)
            ->where('is_active',true);
        } else {
            $data=Warehouse::selectRaw("sysid,loc_code,location_name,inventory_account,cogs_account,expense_account,variant_account,
            warehouse_type,is_received,is_sales,is_distribution,is_active,update_userid,create_date,update_date")
            ->where('warehouse_group',$group_name);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('loc_code', 'ilike', $filter);
                $q->orwhere('location_name', 'ilike', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Warehouse::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->dept_code,'Deleting recods');
                $data->delete();
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
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Warehouse::selectRaw("sysid,loc_code,location_name,inventory_account,cogs_account,expense_account,variant_account,
            warehouse_type,is_received,is_sales,is_distribution,is_active")
        ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'loc_code'=>'bail|required',
            'location_name'=>'bail|required',
        ],[
            'loc_code.required'=>'Kode gudang diisi',
            'location_name.required'=>'Nama gudang diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Warehouse();
                $data->warehouse_group=$row['warehouse_group'];
            } else if ($opr=='updated'){
                $data = Warehouse::find($row['sysid']);
            }
            $data->loc_code=$row['loc_code'];
            $data->location_name=$row['location_name'];
            $data->inventory_account=$row['inventory_account'];
            $data->cogs_account=$row['cogs_account'];
            $data->expense_account=$row['expense_account'];
            $data->variant_account=$row['variant_account'];
            $data->warehouse_type=$row['warehouse_type'];
            $data->is_received=$row['is_received'];
            $data->is_sales=$row['is_sales'];
            $data->is_distribution=$row['is_distribution'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->dept_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
}
