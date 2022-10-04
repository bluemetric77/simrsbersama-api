<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Department;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $group_name=isset($request->group_name) ? $request->group_name : 'OUTPATIENT';
        $data=Department::selectRaw("sysid,dept_code,dept_name,sort_name,wh_medical,wh_general,wh_pharmacy,price_class,
        is_active,update_userid,create_date,update_date")
        ->where('dept_group',$group_name);
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('dept_code', 'like', $filter);
                $q->orwhere('dept_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, 'desc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Department::find($sysid);
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
        $data=Department::from('m_department as a')
        ->selectRaw("a.sysid,a.dept_code,a.dept_name,a.sort_name,a.wh_medical,a.wh_general,a.wh_pharmacy,a.price_class,
        a.is_active,a.update_userid,a.create_date,a.update_date")
        ->where('a.sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'dept_code'=>'bail|required',
            'dept_name'=>'bail|required',
        ],[
            'dept_code.required'=>'Kode klinik diisi',
            'dept_name.required'=>'Nama klinik diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Department();
                $data->dept_group=$row['dept_group'];
            } else if ($opr=='updated'){
                $data = Department::find($row['sysid']);
            }
            $data->dept_code=$row['dept_code'];
            $data->dept_name=$row['dept_name'];
            $data->sort_name=$row['sort_name'];
            $data->wh_medical=$row['wh_medical'];
            $data->wh_general=$row['wh_general'];
            $data->wh_pharmacy=$row['wh_pharmacy'];
            $data->price_class=isset($row['price_class']) ? $row['price_class'] :'';
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
