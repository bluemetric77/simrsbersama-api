<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\ParamedicSpecialist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class ParamedicSpecialistController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $is_active = isset($request->is_active) ? $request->is_active : false;
        if ($is_active) {
            $data=ParamedicSpecialist::selectRaw("sysid,specialist_name");
        } else {
            $data=ParamedicSpecialist::selectRaw("sysid,specialist_name,is_active,update_userid,create_date,update_date");
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('specialist_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=ParamedicSpecialist::find($sysid);
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
        $data=ParamedicSpecialist::selectRaw("sysid,specialist_name,is_active")
        ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'specialist_name'=>'bail|required',
        ],[
            'specialist_name.required'=>'Spesialisasi dokter/paramedik harud  diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new ParamedicSpecialist();
            } else if ($opr=='updated'){
                $data = ParamedicSpecialist::find($row['sysid']);
            }
            $data->specialist_name=$row['specialist_name'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,'','Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function open(Request $request){
        $data=ParamedicSpecialist::selectRaw("sysid,specialist_name")
        ->where('is_active',true)
        ->orderBy('specialist_name')->get();
        return response()->success('Success',$data);
    }
}
