<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Wards;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class WardsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Wards::from('m_wards as a')
            ->selectRaw("a.sysid,a.ward_code,a.ward_name")
            ->where('a.is_active',true);
        } else {
            $data=Wards::from('m_wards as a')
            ->selectRaw("a.sysid,a.ward_code,a.ward_name,a.sort_name,a.is_executive,a.wh_medical,a.wh_general,a.wh_pharmacy,
                a.is_active,a.update_userid,a.create_date,a.update_date,
                b.location_name as wh_medical_code,c.location_name as wh_general_code,
                e.dept_name as dept_code_pharmacy,f.dept_name as inpatient_service")
            ->leftjoin('m_warehouse as b','a.wh_medical','=','b.sysid')
            ->leftjoin('m_warehouse as c','a.wh_general','=','c.sysid')
            ->leftjoin('m_class as d','a.price_class','=','d.sysid')
            ->leftjoin('m_department as e','a.wh_pharmacy','=','e.sysid')
            ->leftjoin('m_department as f','a.dept_sysid','=','f.sysid');
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.ward_code', 'ilike', $filter);
                $q->orwhere('a.ward_name', 'ilike', $filter);
            });
        }
        $data = $data->orderBy('a.'.$sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Wards::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->ward_code,'Deleting recods');
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
        $data=Wards::from('m_wards as a')
            ->selectRaw("a.sysid,a.ward_code,a.ward_name,a.sort_name,a.is_executive,a.wh_medical,a.wh_general,a.wh_pharmacy,a.price_class,
                a.is_active,CONCAT(b.loc_code,' - ',b.location_name) as wh_medical_name,CONCAT(c.loc_code,' - ',c.location_name) as wh_general_name,
                CONCAT(d.dept_code,' - ',d.dept_name) as wh_pharmacy_name,e.dept_name as inpatient_service")
            ->leftjoin('m_warehouse as b','a.wh_medical','=','b.sysid')
            ->leftjoin('m_warehouse as c','a.wh_general','=','c.sysid')
            ->leftjoin('m_department as d','a.wh_pharmacy','=','d.sysid')
            ->leftjoin('m_department as e','a.dept_sysid','=','e.sysid')
        ->where('a.sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'ward_code'=>'bail|required',
            'ward_name'=>'bail|required',
            'dept_sysid'=>'bail|required',
        ],[
            'ward_code.required'=>'Kode ruangan rawat inap harus diisi',
            'ward_name.required'=>'Nama ruangan rawat inap harus diisi',
            'dept_sysid.required'=>'Jenis Layanan rawat inap harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Wards();
            } else if ($opr=='updated'){
                $data = Wards::find($row['sysid']);
            }
            $data->ward_code=$row['ward_code'];
            $data->ward_name=$row['ward_name'];
            $data->sort_name=$row['sort_name'];
            $data->wh_medical=$row['wh_medical'];
            $data->wh_general=$row['wh_general'];
            $data->wh_pharmacy=$row['wh_pharmacy'];
            $data->dept_sysid=$row['dept_sysid'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->ward_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function open(Request $request){
        $data=Wards::selectRaw("sysid,ward_code,ward_name")
        ->where('is_active',true)
        ->orderBy('ward_name','asc')->get();
        return response()->success('Success',$data);
    }
}
