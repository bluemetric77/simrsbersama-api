<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\VehicleGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class VehicleGroupController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=VehicleGroup::selectRaw("vehicle_type,descriptions,main_group,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('vehicle_type', 'like', $filter);
                $q->orwhere('descriptions', 'like', $filter);
                $q->orwhere('main_group', 'like', $filter);
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
        $vehicle_type=isset($request->vehicle_type) ? $request->vehicle_type :'';
        $data=VehicleGroup::find($vehicle_type);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $vehicle_type=isset($request->vehicle_type) ? $request->vehicle_type :'-1';
        $data=VehicleGroup::selectRaw("vehicle_type,descriptions,main_group,is_active")
            ->where('vehicle_type',$vehicle_type)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $valvehicle_typeator=Validator::make($row,
        [
            'vehicle_type'=>'bail|required',
            'descriptions'=>'bail|required',
        ],[
            'vehicle_type.required'=>'Kode pool harus diisi',
            'descriptions.required'=>'Nama pool harus diisi',
        ]);
        if ($valvehicle_typeator->fails()) {
            return response()->error('',501,$valvehicle_typeator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=VehicleGroup::find($row['old_vehicle_type']);
            if ($data){
                $data->update([
                    'vehicle_type'=>$row['vehicle_type'],
                    'descriptions'=>$row['descriptions'],
                    'main_group'=>$row['main_group'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                VehicleGroup::insert([
                    'vehicle_type'=>$row['vehicle_type'],
                    'descriptions'=>$row['descriptions'],
                    'main_group'=>$row['main_group'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Vehicle Group',-1,$row['vehicle_type'],'Jenis kendaraan '.$row['vehicle_type'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=VehicleGroup::selectRaw("vehicle_type,descriptions as vehicle_type_name")
            ->where('is_active','1')
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }
    public function maingetlist(Request $request){
        $data=VehicleGroup::selectRaw("main_group")
            ->distinct()
            ->orderBy('main_group','asc')->get();
        return response()->success('Success',$data);
    }

}
