<?php

namespace App\Http\Controllers\Setup;

use App\Models\Setup\Wards;
use App\Models\Setup\WardRooms;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class WardRoomsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $ward=isset($request->ward) ? $request->ward : -1;
        $is_active=isset($request->is_active) ? $request->is_active : false;
        if ($is_active==true) {
            $data=WardRooms::from('m_ward_rooms as a')
            ->selectRaw("a.sysid,a.ward_sysid,a.room_number,a.capacity,a.occupations,a.room_class_sysid,
                        b.descriptions,b.sort_name")
            ->leftjoin('m_class as b','a.room_class_sysid','=','b.sysid')
            ->where('a.ward_sysid',$ward)
            ->where('a.is_active',true);
        } else {
            $data=WardRooms::from('m_ward_rooms as a')
            ->selectRaw("a.sysid,a.ward_sysid,a.room_number,a.capacity,a.occupations,a.room_class_sysid,
                        b.descriptions as room_class,c.descriptions as service_class,a.is_temporary,
                        a.update_userid,a.create_date,a.update_date")
            ->leftjoin('m_class as b','a.room_class_sysid','=','b.sysid')
            ->leftjoin('m_class as c','a.service_class_sysid','=','c.sysid')
            ->where('a.ward_sysid',$ward);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.room_number', 'like', $filter);
            });
        }
        $data = $data->orderBy('a.'.$sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=WardRooms::find($sysid);
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
        $data=WardRooms::from('m_ward_rooms as a')
        ->selectRaw("a.sysid,a.ward_sysid,a.room_number,a.capacity,a.occupations,a.room_class_sysid,
                    a.service_class_sysid,b.descriptions,b.sort_name,c.descriptions as class_service,a.is_temporary")
        ->leftjoin('m_class as b','a.room_class_sysid','=','b.sysid')
        ->leftjoin('m_class as c','a.service_class_sysid','=','c.sysid')
        ->where('a.sysid',$sysid)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'ward_sysid'=>'bail|required',
            'room_number'=>'bail|required',
            'room_class_sysid'=>'bail|required',
            'service_class_sysid'=>'bail|required',
        ],[
            'ward_sysid.required'=>'Ruangan rawat inap harus diisi',
            'room_number.required'=>'Nama kamar harus diisi',
            'room_class_sysid.required'=>'Kelas kamar rawat inap harus diisi',
            'service_class_sysid.required'=>'Kelas tarif pelayanan/jasa harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new WardRooms();
            } else if ($opr=='updated'){
                $data = WardRooms::find($row['sysid']);
            }
            $data->ward_sysid=$row['ward_sysid'];
            $data->room_number=$row['room_number'];
            $data->capacity=$row['capacity'];
            $data->room_class_sysid=$row['room_class_sysid'];
            $data->service_class_sysid=$row['service_class_sysid'];
            $data->is_temporary=$row['is_temporary'];
            $data->update_userid=PagesHelp::UserID($request);
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->ward_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
}
