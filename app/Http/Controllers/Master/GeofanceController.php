<?php

namespace App\Http\Controllers\Master;

use App\Models\GPS\Geofance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class GeofanceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=Geofance::selectRaw("sysid,geofance_name,IFNULL(location,'') as location,
            IFNULL(warehouse,'') as warehouse,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('geofance_name', 'like', $filter);
                $q->orwhere('warehouse', 'like', $filter);
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
        $data=Geofance::find($sysid);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tersebut ditemukan');
        }
    }

    public function get(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=Geofance::selectRaw("sysid,geofance_name,IFNULL(location,'') as location,IFNULL(warehouse,'') as warehouse,is_active")
            ->where('sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $valsysidator=Validator::make($row,
        [
            'geofance_name'=>'bail|required',
        ],[
            'geofance_name.required'=>'Nama gofance harus diisi',
        ]);
        if ($valsysidator->fails()) {
            return response()->error('',501,$valsysidator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=Geofance::find($row['sysid']);
            if ($data){
                $data->update([
                    'geofance_name'=>$row['geofance_name'],
                    'warehouse'=>$row['warehouse'],
                    'location'=>$row['location'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                Geofance::insert([
                    'geofance_name'=>$row['geofance_name'],
                    'warehouse'=>$row['warehouse'],
                    'location'=>$row['location'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Geofance',-1,$row['sysid'],'Data Goefance '.$row['sysid'].'-'.$row['geofance_name']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=Geofance::selectRaw("sysid,geofance_name,IFNULL(location,'') as location,IFNULL(warehouse,'') as warehouse")
            ->where('is_active','1')
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }

    public function getopen(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=Geofance::selectRaw("sysid,geofance_name,IFNULL(location,'') as location,
            IFNULL(warehouse,'') as warehouse,gps_vendor")
        ->where('is_active','1');   
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('geofance_name', 'like', $filter);
                $q->orwhere('warehouse', 'like', $filter);
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

}
