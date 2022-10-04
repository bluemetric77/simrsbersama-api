<?php

namespace App\Console\GPS;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\GPS\GPSLog;
use App\Models\GPS\GPSDevice;
use App\Models\Master\Vehicles;
use App\Models\GPS\Geofance;
use App\Models\GPS\VehicleGeofance;
use App\Models\GPS\VehicleGPSLogs;
use PagesHelp;

class GPSTotalKilat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gpstotalkilat:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize GPS Total Kilat Devices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url="https://dutamediamandiri.com/api/gps/get";
        $json=null;
        $log=PagesHelp::curl_data($url,null,false);
        if ($log['status']===true){
            $feedback=$log['json'];
            if ($feedback['error_code']=='0'){
                $json=$feedback['data'];
            } 
        }
        if ($json) {
            foreach($json as $data) {
                GPSLog::insert([
                    'provider'=>$data['provider'],
                    'device_id'=>$data['device_id'],
                    'vehicle_number'=>$data['vehicle_number'],
                    'province'=>$data['province'],
                    'district'=>$data['district'],
                    'sub_district'=>$data['sub_district'],
                    'latitude'=>$data['latitude'],
                    'longitude'=>$data['longitude'],
                    'gps_update'=>$data['gps_update'],
                    'gps_update_utc'=>$data['gps_update_utc'],
                    'location'=>$data['location'],
                    'transfer_date_utc'=>$data['transfer_date_utc'],
                    'transfer_date'=>$data['transfer_date'],
                    'hotport'=>isset($data['hotport']) ? $data['hotport'] :'',
                    'odometer'=>$data['odometer'],
                    'acc'=>$data['acc'],
                    'speed'=>$data['speed'],
                    'direction'=>$data['direction'],
                    'gps_signal'=>$data['gps_signal'],
                    'gps_fuel'=>$data['gps_fuel']
                ]);
            }; 
        }
        $last_date=Date('y:m:d', strtotime('-30 days'));
        $gps=GPSLog::selectRaw("sysid,device_id,vehicle_number,latitude,longitude,gps_update,IFNULL(province,'') as province,
                IFNULL(district,'') as district,IFNULL(sub_district,'') as sub_district,
                IFNULL(hotport,'') as hotport,acc,direction,odometer,speed,gps_signal,IFNULL(location,'') as location")
        ->where("transfer_date",">=",$last_date)
        ->where("is_calculate",0)
        ->where("provider",'TDT')
        ->orderBy("gps_update","asc")
        ->limit(1000)->get();
        foreach($gps as $row){
            DB::begintransaction();
            try{
               if (!($row['hotport']=='')) {
                 if (!Geofance::where('geofance_name',$row->hotport)->exists()) {
                    Geofance::insert([
                      'geofance_name' =>$row->hotport,
                      'gps_vendor'=>'TOTAL KILAT',
                      'is_active'=>'1',
                      'update_timestamp'=>Date('Y-m-d')     
                    ]);
                 }
               }
                if (!(GPSDevice::where("device_id",$row['device_id'])->exists())){
                    GPSDevice::insert([
                        'device_id'=>$row->device_id,
                        'vehicle_no'=>$row->vehicle_number,
                        'latitude'=>$row->latitude,
                        'longitude'=>$row->longitude,
                        'gps_update'=>$row->gps_update,
                        'province'=>$row->province,
                        'district'=>$row->district,
                        'sub_district'=>$row->sub_district,
                        'location'=>$row->location,
                        'speed'=>$row->speed,
                        'acc'=>($row->acc=='1') ? 'On':'Off',
                        'gps_signal'=>$row->gps_signal,
                        'direction'=>$row->direction,
                        'geofance'=>$row->hotport,
                        'geofance_in'=>($row->hotport!='') ? $row->gps_update :null,
                        'gps_vendor'=>'TOTAL KILAT',
                        'update_userid'=>'SYSTEM',
                        'update_timestamp'=>Date('Y-m-d H:i:s'),
                    ]);
                } else {
                    GPSDevice::where('device_id',$row->device_id)
                    ->update([
                        'device_id'=>$row->device_id,
                        'vehicle_no'=>$row->vehicle_number,
                        'latitude'=>$row->latitude,
                        'longitude'=>$row->longitude,
                        'gps_update'=>$row->gps_update,
                        'province'=>$row->province,
                        'district'=>$row->district,
                        'sub_district'=>$row->sub_district,
                        'location'=>$row->location,
                        'speed'=>$row->speed,
                        'acc'=>$row->acc,
                        'direction'=>$row->direction,
                        'gps_signal'=>$row->gps_signal,
                        'geofance'=>$row->hotport,
                        'geofance_in'=>($row->hotport!='') ? $row->gps_update :null,
                        'gps_vendor'=>'TOTAL KILAT',
                        'update_userid'=>'SYSTEM',
                        'update_timestamp'=>Date('Y-m-d H:i:s'),
                    ]);
                }
                
                $vehicle=Vehicles::selectRaw("vehicle_no,gps_id,geofance_entered,IFNULL(geofance_name,'') geofance_name,
                        work_order_sysid,log_sysid,state_gps")
                ->where('gps_id',$row['device_id'])->first();
                if ($vehicle) {
                  if (($vehicle->geofance_entered=='0') && (!($row->hotport==''))){
                    Vehicles::where('vehicle_no',$vehicle->vehicle_no)
                    ->update([
                        'latitude'=>$row->latitude,
                        'longitude'=>$row->longitude,
                        'province'=>$row->province,
                        'district'=>$row->district,
                        'sub_district'=>$row->sub_district,
                        'last_address'=>$row->location,
                        'speed'=>$row->speed,
                        'ignation'=>$row->acc,
                        'direction'=>$row->direction,
                        'gps_signal'=>$row->gps_signal,
                        'gps_last_update'=>$row->gps_update,
                        'geofance_entered'=>'1',
                        'geofance_name'=>$row->hotport,
                        'gps_vendor'=>'TOTAL KILAT'
                    ]);
                    VehicleGeofance::insert([
                        'vehicle_no'=>$vehicle->vehicle_no,
                        'device_id'=>$row->device_id,
                        'geofance_name'=>$row->hotport,
                        'geofance_entry'=>$row->gps_update,
                        'gps_update'=>$row->gps_update,
                        'update_timestamp'=>Date('Y-m-d h:i:s')
                    ]);
                  }  
                  if (($vehicle->geofance_entered=='1') && ($row->hotport=='')){
                    VehicleGeofance::where('device_id',$row->device_id)
                    ->where('geofance_name',$vehicle->geofance_name)
                    ->update([
                        'geofance_out'=>$row->gps_update,
                        'gps_update'=>$row->gps_update,
                        'update_timestamp'=>Date('Y-m-d h:i:s')
                    ]);
                    DB::update("UPDATE t_vehicle_geofance SET geofance_time=TIMESTAMPDIFF(MINUTE,geofance_entry,IFNULL(geofance_out,NOW()))
                                WHERE device_id=? AND geofance_name=?",[$row->device_id,$vehicle->geofance_name]); 
                    Vehicles::where('vehicle_no',$vehicle->vehicle_no)
                    ->update([
                        'latitude'=>$row->latitude,
                        'longitude'=>$row->longitude,
                        'province'=>$row->province,
                        'district'=>$row->district,
                        'sub_district'=>$row->sub_district,
                        'last_address'=>$row->location,
                        'speed'=>$row->speed,
                        'ignation'=>$row->acc,
                        'direction'=>$row->direction,
                        'gps_signal'=>$row->gps_signal,
                        'gps_last_update'=>$row->gps_update,
                        'geofance_entered'=>'0',
                        'geofance_name'=>'',
                        'gps_vendor'=>'TOTAL KILAT'
                    ]);
                  } else {
                    Vehicles::where('vehicle_no',$vehicle->vehicle_no)
                    ->update([
                        'latitude'=>$row->latitude,
                        'longitude'=>$row->longitude,
                        'province'=>$row->province,
                        'district'=>$row->district,
                        'sub_district'=>$row->sub_district,
                        'last_address'=>$row->location,
                        'speed'=>$row->speed,
                        'ignation'=>$row->acc,
                        'direction'=>$row->direction,
                        'gps_signal'=>$row->gps_signal,
                        'gps_last_update'=>$row->gps_update,
                        'gps_vendor'=>'TOTAL KILAT'
                    ]);
                  }
                  $state_gps='';
                  if ($row->acc=='Off')  {
                    $state_gps='Parking';
                  } elseif (($row->acc=='On') && (floatval($row->speed)==0)) {
                    $state_gps='Idle';
                  } elseif (($row->acc=='On') && (floatval($row->speed)>0)) {
                    $state_gps='Driving';
                  } else {
                      $state_gps='';
                  }
                  if (!($vehicle->state_gps==$state_gps)) {
                    if ($vehicle->log_sysid!=-1) {
                       VehicleGPSLogs::where('sysid',$vehicle->log_sysid)
                       ->update([
                        'end_date'=>$row->gps_update,
                        'closed'=>'1',
                        'work_order_sysid'=>$vehicle->work_order_sysid
                       ]);
                       DB::update("UPDATE t_vehicle_logs SET value_time=TIMESTAMPDIFF(MINUTE,start_date,IFNULL(end_date,NOW()))
                                   WHERE sysid=?",[$vehicle->log_sysid]); 
                    }
                    $GPSid=VehicleGPSLogs::insertGetId([
                       'vehicle_no'=>$vehicle->vehicle_no,
                       'state'=>$state_gps,
                       'start_date'=>$row->gps_update,
                       'geofance_name'=>$row->hotport,   
                       'closed'=>'0',
                       'value_time'=>0,
                       'work_order_sysid'=>$vehicle->work_order_sysid                           
                    ]);
                    Vehicles::where('vehicle_no',$vehicle->vehicle_no)
                    ->update([
                        'state_gps'=>$state_gps,
                        'log_sysid'=>$GPSid,
                        'state_gps_datetime'=>$row->gps_update
                    ]);
                  }
               }    
               GPSLog::where('sysid',$row->sysid)
               ->update(['is_calculate'=>'1']);
               DB::commit(); 
            } catch(Exception $e) {
               DB::rollback();     
            }
        } 
        $url="https://dutamediamandiri.com/api/gps/remove";
        PagesHelp::curl_data($url,null,false,true);
        return 0;
    }
}
