<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\ParamedicPriceGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class ParamedicPriceGroupController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=ParamedicPriceGroup::selectRaw("sysid,group_code,group_name,is_active,update_userid,create_date,update_date");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('group_code', 'like', $filter);
                $q->orwhere('group_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=ParamedicPriceGroup::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->group_code,'Deleting recods');
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
        $data=ParamedicPriceGroup::selectRaw("sysid,group_code,group_name,is_active")
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
            'group_code.required'=>'Grup tarif dokter harus diisi',
            'group_name.required'=>'Nama grup tarif dokter harud  diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new ParamedicPriceGroup();
            } else if ($opr=='updated'){
                $data = ParamedicPriceGroup::find($row['sysid']);
            }
            $data->group_code=$row['group_code'];
            $data->group_name=$row['group_name'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->group_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function open(Request $request){
        $data=ParamedicPriceGroup::selectRaw("sysid,group_code,group_name")
        ->where('is_active',true)->get();
        return response()->success('Success',$data);
    }
}
