<?php

namespace App\Http\Controllers\Master;

use App\Models\GPS\GPSDevice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class GPSDeviceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=GPSDevice::from('m_gps as a')
        ->selectRaw("a.sysid,a.device_id,a.vehicle_no,a.latitude,a.longitude,a.gps_update,a.location,
        a.speed,a.acc,a.gps_signal,a.geofance,a.direction,a.geofance_in,a.geofance_out,a.gps_vendor,
        b.vehicle_no as vehicle_number,b.police_no,a.update_userid,a.update_timestamp")
        ->leftjoin('m_vehicle as b','a.device_id','=','b.gps_id');
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.device_id', 'like', $filter);
                $q->orwhere('a.vehicle_no', 'like', $filter);
                $q->orwhere('a.gps_vendor', 'like', $filter);
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
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=GPSDevice::find($sysid);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tersebut ditemukan');
        }
    }

    public function get(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=GPSDevice::selectRaw("sysid,device_id,vehicle_no,gps_vendor")
            ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $valsysidator=Validator::make($row,
        [
            'device_id'=>'bail|required',
            'vehicle_no'=>'bail|required',
            'gps_vendor'=>'bail|required',
        ],[
            'device_id.required'=>'ID GPS harus diisi',
            'vehicle_no.required'=>'Nomor polisi/unit harus diisi',
            'gps_vendor.required'=>'Vendor GPS harus diisi',
        ]);
        if ($valsysidator->fails()) {
            return response()->error('',501,$valsysidator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=GPSDevice::find($row['sysid']);
            if ($data){
                $data->update([
                    'device_id'=>$row['device_id'],
                    'vehicle_no'=>$row['vehicle_no'],
                    'gps_vendor'=>$row['gps_vendor'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                GPSDevice::insert([
                    'device_id'=>$row['device_id'],
                    'vehicle_no'=>$row['vehicle_no'],
                    'gps_vendor'=>$row['gps_vendor'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'GPS Device',-1,$row['sysid'],'GPS Device '.$row['sysid'].'-'.$row['device_id']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=GPSDevice::selectRaw("sysid,device_id,vehicle_no,gps_vendor,CONCAT(vehicle_no,' ( ',gps_vendor,'-',device_id,' )') as list")
            ->orderBy('vehicle_no','asc')->get();
        return response()->success('Success',$data);
    }
}
