<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\InventoryGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class InventoryGroupController extends Controller
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
            $data=InventoryGroup::selectRaw("sysid,group_code,group_name,inventory_account,cogs_account,cost_account,variant_account")
            ->where('inventory_group',$group_name)
            ->where('is_active',true);
        } else {
            $data=InventoryGroup::selectRaw("sysid,group_code,group_name,inventory_account,cogs_account,cost_account,variant_account,
            is_active,update_userid,create_date,update_date")
            ->where('inventory_group',$group_name)
            ->where('is_subgroup',false);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('group_code', 'ilike', $filter);
                $q->orwhere('group_name', 'ilike', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=InventoryGroup::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->group_code,'Deleting recods [ '.$data->group_code.'-'.$data->group_name.' ]');
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
        $data=InventoryGroup::selectRaw("sysid,group_code,group_name,inventory_account,cogs_account,cost_account,variant_account,
            is_active")
        ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'group_code'=>'bail|required',
            'group_name'=>'bail|required',
        ],[
            'group_code.required'=>'Kode grup inventory harus diisi',
            'group_name.required'=>'Nama grup inventory harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new InventoryGroup();
                $data->inventory_group=$row['inventory_group'];
            } else if ($opr=='updated'){
                $data = InventoryGroup::find($row['sysid']);
            }
            $data->group_code=$row['group_code'];
            $data->group_name=$row['group_name'];
            $data->inventory_account=$row['inventory_account'];
            $data->cogs_account=$row['cogs_account'];
            $data->cost_account=$row['cost_account'];
            $data->variant_account=$row['variant_account'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->dept_code,'Add/Update recods [ '.$data->group_code.'-'.$data->group_name.' ]');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
}
