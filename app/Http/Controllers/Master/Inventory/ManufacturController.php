<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\Manufactur;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class ManufacturController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Manufactur::selectRaw("sysid,manufactur_code,manufactur_name")
            ->where('is_active',true);
        } else {
            $data=Manufactur::selectRaw("sysid,manufactur_code,manufactur_name,address,phone1,phone2,fax,email,
            contact_person,contact_phone,is_active,update_userid,create_date,update_date");
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('manufactur_code', 'like', $filter);
                $q->orwhere('manufactur_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Manufactur::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->manufactur_code,'Deleting recods '.$data->manufactur_name);
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
        $data=Manufactur::selectRaw("sysid,manufactur_code,manufactur_name,is_active")
        ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'manufactur_code'=>'bail|required',
            'manufactur_name'=>'bail|required',
        ],[
            'manufactur_code.required'=>'Kode pabrik harus diisi',
            'manufactur_name.required'=>'Nama pabrik harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Manufactur();
            } else if ($opr=='updated'){
                $data = Manufactur::find($row['sysid']);
            }
            $data->manufactur_code=$row['manufactur_code'];
            $data->manufactur_name=$row['manufactur_name'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->manufactur_code,'Add/Update recods '.$data->manufactur_name);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function list(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Manufactur::selectRaw("sysid,manufactur_code,manufactur_name")
        ->where('is_active','1')->get();
        return response()->success('Success',$data);
    }    
}
