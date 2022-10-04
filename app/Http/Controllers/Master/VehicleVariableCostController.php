<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\VehicleVariableCost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class VehicleVariableCostController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=VehicleVariableCost::selectRaw("id,descriptions,sortname,account_no,is_invoice,is_fix,is_auto,acuan,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('id', 'like', $filter);
                $q->orwhere('descriptions', 'like', $filter);
            });
        }
        if (!($sortBy == '')) {
            if ($descending) {
                $data = $data->orderBy($sortBy, 'desc')->paginate($limit);
            } else {
                $data = $data->orderBy($sortBy, 'asc')->paginate($limit);
            }
        } else {
            $data = $data->paginate($limit);
        }
        return response()->success('Success', $data);
    }

    public function delete(Request $request){
        $id=isset($request->id) ? $request->id :'-1';
        $data=VehicleVariableCost::find($id);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $id=isset($request->id) ? $request->id :'-1';
        $data=VehicleVariableCost::selectRaw("id,descriptions,sortname,account_no,is_invoice,is_fix,is_auto,acuan,is_active")
            ->where('id',$id)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'descriptions'=>'bail|required',
            'sortname'=>'bail|required',
            'account_no'=>'bail|required',
            'acuan'=>'bail|required',
        ],[
            'descriptions.required'=>'Nama variable harus diisi',
            'sortname.required'=>'Singkatan variable harus diisi',
            'account_no.required'=>'Kode account harus diisi',
            'acuan.required'=>'Acuan variable harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=VehicleVariableCost::find($row['id']);
            if ($data){
                $data->update([
                    'descriptions'=>$row['descriptions'],
                    'sortname'=>$row['sortname'],
                    'account_no'=>$row['account_no'],
                    'acuan'=>$row['acuan'],
                    'is_invoice'=>$row['is_invoice'],
                    'is_fix'=>$row['is_fix'],
                    'is_auto'=>$row['is_auto'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                $id=VehicleVariableCost::max('id');
                $id=intval($id)+1;
                VehicleVariableCost::insert([
                    'id'=>$id,
                    'descriptions'=>$row['descriptions'],
                    'sortname'=>$row['sortname'],
                    'account_no'=>$row['account_no'],
                    'acuan'=>$row['acuan'],
                    'is_invoice'=>$row['is_invoice'],
                    'is_fix'=>$row['is_fix'],
                    'is_auto'=>$row['is_auto'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Variable',-1,$row['id'],'Variable operasional kendaraan '.$row['id'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=VehicleVariableCost::selectRaw("id,descriptions as variable_name,sortname,is_fix,is_invoice")
            ->where('is_active','1')
            ->orderBy('id','asc')->get();
        return response()->success('Success',$data);
    }
}
