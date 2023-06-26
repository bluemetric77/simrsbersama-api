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
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Department::from('m_department as a')
            ->selectRaw("a.sysid,a.dept_code,a.dept_name")
            ->where('a.dept_group',$group_name)
            ->where('a.is_active',true);
        } else {
            $data=Department::from('m_department as a')
            ->selectRaw("a.sysid,a.dept_code,a.dept_name,a.sort_name,a.is_executive,a.wh_medical,a.wh_general,a.wh_pharmacy,a.price_class,
                a.is_active,a.update_userid,a.create_date,a.update_date,
                b.location_name as wh_medical_code,c.location_name as wh_general_code,d.descriptions as price_class_name,
                e.dept_name as dept_code_pharmacy")
            ->leftjoin('m_warehouse as b','a.wh_medical','=','b.sysid')
            ->leftjoin('m_warehouse as c','a.wh_general','=','c.sysid')
            ->leftjoin('m_class as d','a.price_class','=','d.sysid')
            ->leftjoin('m_department as e','a.wh_pharmacy','=','e.sysid')
            ->where('a.dept_group',$group_name);

        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.dept_code', 'like', $filter);
                $q->orwhere('a.dept_name', 'like', $filter);
            });
        }
        $data = $data->orderBy('a.'.$sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
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
            ->selectRaw("a.sysid,a.dept_code,a.dept_name,a.sort_name,a.is_executive,a.wh_medical,a.wh_general,a.wh_pharmacy,a.price_class,
                a.is_active,CONCAT(b.location_code,' - ',b.location_name) as wh_medical_name,CONCAT(c.location_code,' - ',c.location_name) as wh_general_name,
                CONCAT(d.price_code,' - ',d.descriptions) as price_class_name,CONCAT(e.dept_code,' - ',e.dept_name) as wh_pharmacy_name")
            ->leftjoin('m_warehouse as b','a.wh_medical','=','b.sysid')
            ->leftjoin('m_warehouse as c','a.wh_general','=','c.sysid')
            ->leftjoin('m_class as d','a.price_class','=','d.sysid')
            ->leftjoin('m_department as e','a.wh_pharmacy','=','e.sysid')
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
            'dept_name'=>'bail|required',
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
            $data->is_executive=isset($row['is_executive']) ? $row['is_executive'] :'';
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
