<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Paramedic;
use App\Models\Setup\ParamedicSpecialist;
use App\Models\Setup\ParamedicProfile;
use App\Models\Setup\ParamedicPriceGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class ParamedicController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $paramedic_type=isset($request->paramedic_type) ? $request->paramedic_type : 'DOCTOR';
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Paramedic::from('m_paramedic as a')
            ->selectRaw("a.sysid,a.paramedic_code,a.paramedic_name,a.price_group,b.specialist_name")
            ->leftjoin('m_specialist as b','a.specialist_sysid','=','b.sysid')
            ->where('a.paramedic_type',$paramedic_type)
            ->where('a.is_active',true);
        } else {
            $data=Paramedic::from('m_paramedic as a')
            ->selectRaw("a.sysid,a.paramedic_code,a.paramedic_name,b.specialist_name,c.group_code as price_group,a.paramedic_type,a.employee_id,
                        a.is_internal,a.is_permanent,a.tax_number,email,bank_name,a.account_name,a.account_number,a.update_userid,a.create_date,a.update_date")
            ->leftjoin('m_specialist as b','a.specialist_sysid','=','b.sysid')
            ->leftjoin('m_price_paramedic_groups as c','a.price_group','=','b.sysid')
            ->where('a.paramedic_type',$paramedic_type);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.paramedic_code', 'ilike', $filter);
                $q->orwhere('a.paramedic_name', 'ilike', $filter);
                $q->orwhere('b.specialist_name', 'ilike', $filter);
            });
        }
        if ($sortBy=='specialist_name') {
            $sortBy='b.'.$sortBy;
        } else {
            $sortBy='a.'.$sortBy;
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Paramedic::find($sysid);
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
        $data=Paramedic::from('m_paramedic as a')
        ->selectRaw("a.sysid,a.paramedic_code,a.paramedic_name,b.specialist_name,c.group_code as price_group,a.paramedic_type,a.employee_id,
                    a.is_internal,a.is_permanent,a.tax_number,email,bank_name,a.account_name,a.account_number,a.is_active")
        ->leftjoin('m_specialist as b','a.specialist_sysid','=','b.sysid')
        ->leftjoin('m_price_paramedic_groups as c','a.price_group','=','b.sysid')
        ->where('a.sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'paramedic_code'=>'bail|required',
            'paramedic_name'=>'bail|required',
            'paramedic_type'=>'bail|required',
        ],[
            'paramedic_code.required'=>'Kode dokter/paramedic harus diisi',
            'paramedic_name.required'=>'Nama dokter/paramedic harus diisi',
            'paramedic_type.required'=>'Kelompok dokter/paramedic harus',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $opr=($row['sysid']==-1) ? 'inserted' :'updated';
            if ($opr=='inserted'){
                $data = new Paramedic();
                $data->paramedic_type=$row['paramedic_type'];
            } else if ($opr=='updated'){
                $data = Paramedic::find($row['sysid']);
            }
            $data->paramedic_code=$row['paramedic_code'];
            $data->paramedic_name=$row['paramedic_name'];
            $data->price_group=$row['price_group'];
            $data->is_internal=$row['is_internal'];
            $data->is_permanent=$row['is_permanent'];
            $data->tax_number=$row['tax_number'];
            $data->is_have_tax=($row['tax_number']=='') ? false : true;
            $data->email=isset($row['email']) ? $row['email'] :'';
            $data->is_email_reports=isset($row['is_email_reports']) ? $row['is_email_reports'] :false;
            $data->is_transfer=isset($row['is_transfer']) ? $row['is_transfer'] :false;
            $data->bank_name=isset($row['bank_name']) ? $row['bank_name'] :'';
            $data->account_name=isset($row['bank_name']) ? $row['bank_name'] :'';
            $data->account_number=isset($row['account_number']) ? $row['account_number'] :'';
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->paramedic_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
}
