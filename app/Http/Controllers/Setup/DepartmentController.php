<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Department;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Helpers;

class DepartmentController extends Controller
{
    public function show(Request $request)
    {
        $filter     = $request->filter;
        $limit      = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy     = $request->sortBy;
        $group_name = isset($request->group_name) ? $request->group_name : 'OUTPATIENT';
        $is_active  = isset($request->is_active) ? $request->is_active : false;

        if ($is_active==true) {
            $data=Department::from('m_department as a')
            ->selectRaw("a.sysid,a.dept_code,a.dept_name")
            ->where('a.dept_group',$group_name)
            ->where('a.is_active',true);
        } else {
            $data=Department::from('m_department as a')
            ->selectRaw("a.sysid,a.dept_code,a.dept_name,a.sort_name,a.is_executive,a.wh_medical,a.wh_general,a.wh_pharmacy,a.price_class,
                a.is_active,a.created_by,a.created_date,a.updated_by,a.updated_date,
                b.location_name as wh_medical_code,c.location_name as wh_general_code,d.descriptions as price_class_name,
                e.dept_name as dept_code_pharmacy,a.uuid_rec")
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
        $uuid_rec=isset($request->uuid_rec) ? $request->uuid_rec :'N/A';
        $data=Department::where('uuid_rec',$uuid_rec)->first();
        if ($data) {
            DB::beginTransaction();
            try{
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

    public function get(Request $request){
        $uuid_rec=isset($request->uuid_rec) ? $request->uuid_rec :'N/A';
        $data=Department::from('m_department as a')
            ->selectRaw("a.sysid,a.dept_code,a.dept_name,a.sort_name,a.is_executive,a.wh_medical,a.wh_general,a.wh_pharmacy,a.price_class,
                a.is_active,CONCAT(b.location_code,' - ',b.location_name) as wh_medical_name,CONCAT(c.location_code,' - ',c.location_name) as wh_general_name,
                CONCAT(d.price_code,' - ',d.descriptions) as price_class_name,CONCAT(e.dept_code,' - ',e.dept_name) as wh_pharmacy_name,a.uuid_rec")
            ->leftjoin('m_warehouse as b','a.wh_medical','=','b.sysid')
            ->leftjoin('m_warehouse as c','a.wh_general','=','c.sysid')
            ->leftjoin('m_class as d','a.price_class','=','d.sysid')
            ->leftjoin('m_department as e','a.wh_pharmacy','=','e.sysid')
        ->where('a.uuid_rec',$uuid_rec)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'dept_code'=>'bail|required',
            'dept_name'=>'bail|required',
        ],[
            'dept_code.required'=>'Kode klinik harus diisi',
            'dept_name.required'=>'Nama klinik haruss diisi',
        ]);

        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }

        $info=Helpers::Session();

        DB::beginTransaction();
        try {
            $data = Department::where('uuid_rec',isset($row['uuid_rec']) ? $row['uuid_rec'] :'')
            ->first();
            if (!($data)){
                $data = new Department();
                $data->sysid        = Helpers::SeriesField('m_department');
                $data->dept_group   = $row['dept_group'];
                $data->created_by   = Helpers::Session()->sysid;
                $data->created_date = Date('Y-m-d H:i:s');
                $data->uuid_rec     = str::uuid();

            } else {
                $data->updated_by   = Helpers::Session()->sysid;
                $data->updated_date = Date('Y-m-d H:i:s');
            }

            $data->dept_code    = $row['dept_code'];
            $data->dept_name    = $row['dept_name'];
            $data->sort_name    = $row['sort_name'];
            $data->wh_medical   = $row['wh_medical'];
            $data->wh_general   = $row['wh_general'];
            $data->wh_pharmacy  = $row['wh_pharmacy'];
            $data->price_class  = isset($row['price_class']) ? $row['price_class'] :'';
            $data->is_executive = isset($row['is_executive']) ? $row['is_executive'] :'';
            $data->is_active    = $row['is_active'];
            $data->save();

            DB::commit();

            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();
        }
    }
}
