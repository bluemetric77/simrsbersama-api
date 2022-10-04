<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\VehicleGroup;
use App\Models\Master\Vehicles;
use App\Models\Master\VehicleDocuments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;
use App\Models\GPS\GPSDevice;
use Illuminate\Support\Facades\Storage;

class VehiclesController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=Vehicles::from('m_vehicle as a')
        ->selectRaw("a.vehicle_no,a.descriptions,a.model,a.manufactur,a.year_production,a.police_no,a.vin,a.chasis_no,a.vehicle_type,
           a.vehicle_status,a.vehicle_km,a.stnk_validate,a.kir_validate,a.vehicle_tax_validate,a.notes,a.purchase_date,a.asset_number,
           a.tire_type,a.pool_code,a.unit_type,a.gps_vendor,a.chassis_id,a.gps_id,a.employee_id,
           CONCAT(IFNULL(a.employee_id,''),' - ',IFNULL(b.personal_name,'')) as personal_name,
           a.gps_id,a.gps_vendor,a.is_active,a.update_userid,a.update_timestamp")
        ->leftjoin("m_personal as b","a.employee_id","=","b.employee_id");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('vehicle_no', 'like', $filter);
                $q->orwhere('descriptions', 'like', $filter);
                $q->orwhere('vin', 'like', $filter);
                $q->orwhere('chasis_no', 'like', $filter);
                $q->orwhere('police_no', 'like', $filter);
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

    public function open(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $pool_code=isset($request->pool_code)? $request->pool_code :'';
        $data=Vehicles::selectRaw("vehicle_no,descriptions,model,manufactur,police_no,vehicle_status,pool_code,unit_type,vehicle_type")
           ->where('is_active','1');
        if ($pool_code!='') {
            $data=$data->where('pool_code',$pool_code);
        }   
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('vehicle_no', 'like', $filter);
                $q->orwhere('descriptions', 'like', $filter);
                $q->orwhere('vin', 'like', $filter);
                $q->orwhere('chasis_no', 'like', $filter);
                $q->orwhere('police_no', 'like', $filter);
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
        $vehicle_no=isset($request->vehicle_no) ? $request->vehicle_no :'';
        $data=Vehicles::find($vehicle_no);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $vehicle_no=isset($request->vehicle_no) ? $request->vehicle_no :'-1';
        $data=Vehicles::from('m_vehicle as a')
        ->selectRaw("a.vehicle_no,a.descriptions,a.model,a.manufactur,a.year_production,a.police_no,a.vin,a.chasis_no,a.vehicle_type,
           a.vehicle_status,a.vehicle_km,a.stnk_validate,a.kir_validate,a.vehicle_tax_validate,a.notes,a.purchase_date,a.asset_number,
           a.tire_type,a.pool_code,a.unit_type,a.gps_vendor,a.chassis_id,a.gps_id,a.employee_id,
           CONCAT(IFNULL(a.employee_id,''),' - ',IFNULL(b.personal_name,'')) as personal_name,a.is_active")
        ->leftjoin("m_personal as b","a.employee_id","=","b.employee_id")
            ->where('vehicle_no',$vehicle_no)->first();
        return response()->success('Success',$data);
    }

    public function document(Request $request){
        $vehicle_no=isset($request->vehicle_no) ? $request->vehicle_no :'-1';
        $vehicle=Vehicles::selectRaw("vehicle_no,descriptions,police_no,vin,chasis_no")
            ->where('vehicle_no',$vehicle_no)->first();
        $document=VehicleDocuments::selectRaw("sysid,create_date,document_link,descriptions")
            ->where('vehicle_no',$vehicle_no)->get();
        $data['vehicle']=$vehicle;    
        $data['document']=$document;    
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'vehicle_no'=>'bail|required',
            'descriptions'=>'bail|required',
            'tire_type'=>'bail|required',
            'vehicle_type'=>'bail|required',
            'model'=>'bail|required',
            'vin'=>'bail|required',
            'chasis_no'=>'bail|required',
            'police_no'=>'bail|required',
            'pool_code'=>'bail|required',
        ],[
            'vehicle_no.required'=>'Kode pool harus diisi',
            'descriptions.required'=>'Nama pool harus diisi',
            'tire_type.required'=>'Jenis ban harus diisi',
            'vehicle_type.required'=>'Jenis kendaraan harus diisi',
            'model.required'=>'Model kendaraan harus diisi',
            'vin.required'=>'Nomor mesin kendaraan harus diisi',
            'chasis_no.required'=>'Nomor rangka kendaraan harus diisi',
            'police_no.required'=>'Nomor polisi harus diisi',
            'pool_code.required'=>'Pool kendaraan harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($row['personal_name']=="") {
                $row['employee_id']="";
            }
            $data=Vehicles::find($row['old_vehicle_no']);
            if ($data){
                $data->update([
                    'vehicle_no'=>$row['vehicle_no'],
                    'descriptions'=>$row['descriptions'],
                    'vehicle_type'=>$row['vehicle_type'],
                    'model'=>$row['model'],
                    'manufactur'=>$row['manufactur'],
                    'year_production'=>$row['year_production'],
                    'unit_type'=>$row['unit_type'],
                    'police_no'=>$row['police_no'],
                    'vin'=>$row['police_no'],
                    'chasis_no'=>$row['chasis_no'],
                    'gps_vendor'=>isset($row['gps_vendor']) ? $row['gps_vendor']:'',
                    'gps_id'=>$row['gps_id'],
                    'tire_type'=>$row['tire_type'],
                    'pool_code'=>$row['pool_code'],
                    'stnk_validate'=>$row['stnk_validate'],
                    'kir_validate'=>$row['kir_validate'],
                    'vehicle_tax_validate'=>$row['vehicle_tax_validate'],
                    'purchase_date'=>isset($row['purchase_date']) ? $row['purchase_date'] :null,
                    'purchase_amount'=>isset($row['purchase_amount']) ? $row['purchase_amount'] :0,
                    'asset_number'=>isset($row['asset_number']) ? $row['asset_number'] :'',
                    'asset_value'=>isset($row['asset_value']) ? $row['asset_value'] :0,
                    'employee_id'=>isset($row['employee_id']) ? $row['employee_id'] :"",
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                Vehicles::insert([
                    'vehicle_no'=>$row['vehicle_no'],
                    'descriptions'=>$row['descriptions'],
                    'vehicle_type'=>$row['vehicle_type'],
                    'model'=>$row['model'],
                    'manufactur'=>$row['manufactur'],
                    'year_production'=>$row['year_production'],
                    'unit_type'=>$row['unit_type'],
                    'police_no'=>$row['police_no'],
                    'vin'=>$row['police_no'],
                    'chasis_no'=>$row['chasis_no'],
                    'gps_vendor'=>isset($row['gps_vendor']) ? $row['gps_vendor']:'',
                    'gps_id'=>$row['gps_id'],
                    'tire_type'=>$row['tire_type'],
                    'pool_code'=>$row['pool_code'],
                    'stnk_validate'=>$row['stnk_validate'],
                    'kir_validate'=>$row['kir_validate'],
                    'vehicle_tax_validate'=>$row['vehicle_tax_validate'],
                    'purchase_date'=>isset($row['purchase_date']) ? $row['purchase_date'] :null,
                    'purchase_amount'=>isset($row['purchase_amount']) ? $row['purchase_amount'] :0,
                    'asset_number'=>isset($row['asset_number']) ? $row['asset_number'] :'',
                    'asset_value'=>isset($row['asset_value']) ? $row['asset_value'] :0,
                    'employee_id'=>isset($row['employee_id']) ? $row['employee_id'] :"",
                    'is_active'=>$row['is_active'],
                    'vehicle_status'=>'Standby',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Vehicles',-1,$row['vehicle_no'],'Data kendaraan '.$row['vehicle_no'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=Vehicles::selectRaw("vehicle_no,descriptions as vehicle_name")
            ->where('is_active','1')
            ->orderBy('vehicle_no','asc')->get();
        return response()->success('Success',$data);
    }

    public function upload(Request $request){
        $validator=Validator::make($request->all(),
        [
            'vehicle_no'=>'bail|required',
            'title'=>'bail|required',
            'file'=>'bail|required',
            'descriptions'=>'bail|required'
        ],[
            'vehicle_no.required'=>'Nomor unit harus diisi',
            'title.required'=>'Judul dokumen harus diisi',
            'file.required'=>'File upload harus diisi',
            'descriptions.required'=>'Keterangan harus diisi'
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        $vehicle_no=$request->vehicle_no;
        $uploadedFile = $request->file('file');
        if ($uploadedFile){
            $originalFile = 'img_'.$vehicle_no.'_'.$uploadedFile->getClientOriginalName();        
            $directory="public/vehicle";
            $path = $uploadedFile->storeAs($directory,$originalFile);
            VehicleDocuments::insert([
                'vehicle_no'=>$request->vehicle_no,
                'title'=>$request->title,
                'descriptions'=>$request->descriptions,
                'document_link'=>$path,
                'create_date'=>Date("Y-m-d"),
                'update_timestamp'=>Date('Y-m-d h:i:s'),
                'update_userid'=>PagesHelp::UserID($request)
            ]);
            return response()->success('Success', 'Upload data berhasil');
        }
   }
    public function download(Request $request)
    {
        $sysid = isset($request->sysid) ? $request->sysid : -1;
        $data=VehicleDocuments::selectRaw(
            "IFNULL(document_link,'') as document_link")->where('sysid',$sysid)->first();
        if ($data) {
            $publicPath = \Storage::url($data->document_link);
            $headers = array('Content-Type: application/image');
            return Storage::download($data->document_link);            
        } else {
              return response()->error('',301,'Dokumen tidak ditemukan');
        }
    }

    public function remove(Request $request){
        $sysid=isset($request->sysid) ? $request->sysid :'-1';
        $data=VehicleDocuments::find($sysid);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }
    public function GPSEasyGo()
    {   
        /** Get Vehicle Master **/
        $url="https://vtsapi.easygo-gps.co.id/api/master/Vehicles";
        $json=null;
        $data='{
            "account_id": 0,
            "vehicle_no": "",
            "vehicle_code": ""
            }';
        $log=PagesHelp::curl_data($url,$data,true,false,true);
        if ($log['status']===true){
            $feedback=$log['json'];
            //return response()->success('Success',$feedback);
            if ($feedback) {
                if ($feedback['ResponseCode']=='1'){
                    $json=$feedback['Data'];
                } 
            }
        }
        if ($json) {
            foreach($json as $data) {
                if (!(GPSDevice::where("device_id",$data['gps_sn'])->exists())){
                    GPSDevice::insert([
                        'device_id'=>$data['gps_sn'],
                        'vehicle_no'=>$data['nopol'],
                        'latitude'=>'',
                        'longitude'=>'',
                        'gps_update'=>Date('Y-m-d h:i:s'),
                        'location'=>'',
                        'speed'=>'',
                        'acc'=>'',
                        'gps_signal'=>'1',
                        'geofance'=>'',
                        'gps_vendor'=>'EASY GO',
                    ]);
                }; 
            }
        }    
        return response()->success('Success','Berhasil');
    }
}
