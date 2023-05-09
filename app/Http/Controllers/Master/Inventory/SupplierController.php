<?php

namespace App\Http\Controllers\Master\Inventory;

use App\Models\Master\Inventory\Supplier;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=Supplier::selectRaw("sysid,supplier_code,supplier_name")
            ->where('is_active',true);
        } else {
            $data=Supplier::selectRaw("sysid,supplier_code,supplier_name,address,phone1,phone2,fax,email,contact_person,contact_email,
            contact_phone,bank_name,bank_account_name,bank_account_number,lead_time,is_active,update_userid,create_date,update_date");
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('supplier_code', 'like', $filter);
                $q->orwhere('supplier_name', 'like', $filter);
            });
        }
        $data = $data->orderBy($sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Supplier::find($sysid);
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->supplier_code,'Deleting recods '.$data->supplier_name);
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
            $data=Supplier::selectRaw("sysid,supplier_code,supplier_name,address,phone1,phone2,fax,email,contact_person,contact_email,
                contact_phone,bank_name,bank_account_name,bank_account_number,lead_time,is_active")
        ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'supplier_code'=>'bail|required',
            'supplier_name'=>'bail|required',
        ],[
            'supplier_code.required'=>'Kode pabrik harus diisi',
            'supplier_name.required'=>'Nama pabrik harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new Supplier();
            } else if ($opr=='updated'){
                $data = Supplier::find($row['sysid']);
            }
            $data->supplier_code=$row['supplier_code'];
            $data->supplier_name=$row['supplier_name'];
            $data->address=$row['address'];
            $data->phone1=$row['phone1'];
            $data->phone2=$row['phone2'];
            $data->fax=$row['fax'];
            $data->email=$row['email'];
            $data->contact_person=$row['contact_person'];
            $data->contact_email=$row['contact_email'];
            $data->contact_phone=$row['contact_phone'];
            $data->bank_name=$row['bank_name'];
            $data->bank_account_name=$row['bank_account_name'];
            $data->bank_account_number=$row['bank_account_number'];
            $data->lead_time=$row['lead_time'];
            $data->is_active=$row['is_active'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->supplier_code,'Add/Update recods '.$data->supplier_name);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function list(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Supplier::selectRaw("sysid,supplier_code,supplier_name")
        ->where('is_active','1')->get();
        return response()->success('Success',$data);
    }    
}
