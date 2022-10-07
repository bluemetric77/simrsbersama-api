<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\ServiceClass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class ServiceClassController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=ServiceClass::selectRaw("sysid,price_code,descriptions,sort_name,is_base_price,is_price_class,is_service_class,
        is_pharmacy_class,is_bpjs_class,factor_inpatient,factor_service,factor_pharmacy,minimum_deposit,update_userid,create_date,
        update_date");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('descriptions', 'ilike', $filter);
                $q->orwhere('sort_name', 'ilike', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=ServiceClass::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->price_code,'Deleting recods');
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
        $data=ServiceClass::
        selectRaw("sysid,price_code,descriptions,sort_name,is_base_price,is_price_class,is_service_class,
                  is_pharmacy_class,is_bpjs_class,factor_inpatient,factor_service,factor_pharmacy,minimum_deposit")
        ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'price_code'=>'bail|required',
            'descriptions'=>'bail|required',
        ],[
            'price_code.required'=>'Kode kelas diisi',
            'descriptions.required'=>'Nama kelas diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new ServiceClass();
            } else if ($opr=='updated'){
                $data = ServiceClass::find($row['sysid']);
            }
            $data->price_code=$row['price_code'];
            $data->descriptions=$row['descriptions'];
            $data->sort_name=$row['sort_name'];
            $data->is_base_price=$row['is_base_price'];
            $data->is_price_class=$row['is_price_class'];
            $data->is_service_class=$row['is_service_class'];
            $data->is_pharmacy_class=$row['is_pharmacy_class'];
            $data->is_bpjs_class=$row['is_bpjs_class'];
            $data->factor_inpatient=$row['factor_inpatient'];
            $data->factor_service=$row['factor_service'];
            $data->factor_pharmacy=$row['factor_pharmacy'];
            $data->minimum_deposit=$row['minimum_deposit'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->price_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function open(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $models = isset($request->models) ? $request->models : 'SERVICE'; 
        $data=ServiceClass::selectRaw("sysid,price_code,descriptions,sort_name");
        if ($models=='SERVICE') {
            $data=$data->where('is_price_class',true);
        } else if ($models=='INPATIENT') {
            $data=$data->where('is_service_class',true);
        } else if ($models=='INPATIENT') {
            $data=$data->where('is_pharmacy_class',true);
        } else if ($models=='BPJS') {
            $data=$data->where('is_bpjs_class',true);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('descriptions', 'ilike', $filter);
                $q->orwhere('sort_name', 'ilike', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }
}
