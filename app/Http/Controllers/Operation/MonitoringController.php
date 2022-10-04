<?php

namespace App\Http\Controllers\Operation;

use App\Models\Operation\FleetOrder;
use App\Models\GPS\GPSDevice;
use App\Models\GPS\VehicleGeofance;
use App\Models\Master\Vehicles;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $pool_code = isset($request->pool_code) ? $request->pool_code:'ALL';
        $vehicle_type = isset($request->vehicle_type) ? $request->vehicle_type:'ALL';
        $all = isset($request->all) ? $request->all:'1';
        $date1 = isset($request->date1) ? $request->date1:'1899-12-31';
        $date2 = isset($request->date2) ? $request->date2:'1899-12-31';

        $data=FleetOrder::from("t_fleet_order as a")
        ->selectRaw("a.transid,a.ref_date,a.order_no,a.pool_code,a.work_order_no,a.customer_no,a.customer_no1,a.customer_no2,
            a.vehicle_no,a. police_no, a.employee_id,a.driver_name,a.work_order_type,b.partner_name,
            a.origins,a.destination,a.warehouse,a.price,a.real_tonase,a.tonase,a.net_price,
            a.other_bill,a.over_night,a.total,a.budget,a.dp_customer,a.work_status,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,
            a.standart_fleet_cost,a.project_id,a.eta,a.duration,a.update_userid,a.update_timestamp,
            a.origins_geofance,a.origins_geofance_in,a.origins_geofance_out,
            a.destinations_geofance,a.destinations_geofance_in,a.destinations_geofance_out")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->join("m_vehicle as c","a.vehicle_no","=","c.vehicle_no")
        ->join("m_vehicle_group as d","a.vehicle_group","=","d.vehicle_type")
        ->where("a.ref_date",">=",$date1)
        ->where("a.ref_date","<=",$date2);

        if (!($pool_code=='ALL')) {
            $data=$data->where('a.pool_code',$pool_code);
        }
        if (!($vehicle_type=='ALL')) {
            $data=$data->where('d.main_group',$vehicle_type);
        }
        if ($all=='0') {
            $data=$data->where('a.Work_status','Open');
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.order_no', 'like', $filter);
                $q->orwhere('a.work_order_no', 'like', $filter);
                $q->orwhere('a.customer_no', 'like', $filter);
                $q->orwhere('b.partner_name', 'like', $filter);
                $q->orwhere('a.origins', 'like', $filter);
                $q->orwhere('a.destination', 'like', $filter);
                $q->orwhere('a.warehouse', 'like', $filter);
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

    public function dashboard1(Request $request){
        $pool_code=isset($request->pool_code) ? $request->pool_code :'ALL';
        $data['total']=0;
        $data['update']=0;
        $data['non_update']=0;
        $data['driving']=0;
        $data['idle']=0;
        $data['parking']=0;
        $data['loading']=0;
        $data['unloading']=0;
        $data['service']=0;
        $vehicle=Vehicles::selectRaw("COUNT(*) AS total,SUM(IF(IFNULL(gps_id,'')='',0,1)) AS gps,
            SUM(IF(TIMESTAMPDIFF(HOUR,IFNULL(gps_last_update,'1899-12-31 00:00:00'),NOW())>24,0,1)) AS updated,
            SUM(IF(state_gps='Driving',1,0)) as driving,
            SUM(IF(state_gps='Parking',1,0)) as parking,
            SUM(IF(state_gps='Idle' AND speed=0,1,0)) as idle,
            SUM(IF(geofance_in=1,1,0)) as loading,
            SUM(IF(geofance_out=1,1,0)) as unloading")
        ->where("is_active","1")
        ->where("unit_type","<>","CHASSIS");
        if ($pool_code!='ALL') {
            $vehicle=$vehicle
            ->where('pool_code',$pool_code)->first();
        } else {
            $vehicle=$vehicle->first();
        }
        if ($vehicle) {
            $data['total']=$vehicle->total;
            $data['update']=$vehicle->updated;
            $data['non_update']=$vehicle->total-$vehicle->updated;
            $data['driving']=$vehicle->driving;
            $data['idle']=$vehicle->idle;
            $data['parking']=$vehicle->parking;
            $data['loading']=$vehicle->loading;
            $data['unloading']=$vehicle->unloading;
        }

        return response()->success('Success', $data);
    }
    public function units(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $gps_only=isset($request->gps_only) ? $request->gps_only :'0';
        $pool_code = isset($request->pool_code) ? $request->pool_code:'ALL';
        $all = isset($request->all) ? $request->all:'1';
        $vehicle_type = isset($request->vehicle_type) ? $request->vehicle_type:'ALL';
        $data=Vehicles::from('m_vehicle as a')
        ->selectRaw("a.vehicle_no,a.descriptions,a.model,a.manufactur,a.year_production,a.police_no,a.vin,a.chasis_no,a.vehicle_type,
           a.pool_code,a.unit_type,a.gps_vendor,a.chassis_id,a.gps_id,a.latitude,a.longitude,a.last_address,a.ignation,a.speed,a.gps_signal,
           a.gps_last_update,province,district,sub_district,state_gps,IF(gps_last_update IS NOT NULL,TIMESTAMPDIFF(MINUTE,state_gps_datetime,NOW()) ,0) AS minutes,
           state_gps_datetime,geofance_name,IFNULL(work_order_number,'') as work_order_number,work_order_date,work_order_sysid,work_order_driver_name")
        ->join("m_vehicle_group as b","a.vehicle_type","=","b.vehicle_type")
        ->where('a.is_active','1') ; 
        if ($pool_code!='ALL') {
            $data=$data->where('a.pool_code',$pool_code);
        }
        if ($all=='0') {
            $data=$data->where('a.work_order_sysid','<>','-1');
        }

        if ($gps_only=='1'){
            $data=$data->whereRaw("IFNULL(a.gps_id,'')<>''");
        }
        if (!($vehicle_type=='ALL')) {
            $data=$data->where('b.main_group',$vehicle_type);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.vehicle_no', 'like', $filter);
                $q->orwhere('a.descriptions', 'like', $filter);
                $q->orwhere('a.vin', 'like', $filter);
                $q->orwhere('a.chasis_no', 'like', $filter);
                $q->orwhere('a.police_no', 'like', $filter);
            });
        }
        if (!($sortBy == '')) {
            $sortBy='a.'.$sortBy;
            if ($descending) {
                $data = $data->orderBy($sortBy, 'desc')->paginate($limit);
            } else {
                $data = $data->orderBy($sortBy, 'asc')->paginate($limit);
            }
        } else {
            $data = $data->paginate($limit);
        }
        $data=$data->toArray();
        $rows=array();
        foreach($data['data'] as $row){
            $row['minutes_text']=PagesHelp::convert_minutes($row['minutes']);
            $rows[]=$row;
        }
        $data['data']=$rows;
        return response()->success('Success', $data);
    }

    public function units_state(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $pool_code=isset($request->pool_code) ? $request->pool_code :'ALL';
        $state=isset($request->state) ? $request->state :'ALL';
        $data=Vehicles::from('m_vehicle as a')
        ->selectRaw("a.vehicle_no,a.descriptions,a.model,a.manufactur,a.year_production,a.police_no,a.vin,a.chasis_no,a.vehicle_type,
           a.pool_code,a.unit_type,a.gps_vendor,a.chassis_id,a.gps_id,a.latitude,a.longitude,a.last_address,a.ignation,a.speed,a.gps_signal,
           a.gps_last_update,a.province,a.district,a.sub_district,a.state_gps,a.work_order_date,a.work_order_number,a.work_order_sysid,
           a.work_order_driver_name,IF(gps_last_update IS NOT NULL,TIMESTAMPDIFF(MINUTE,state_gps_datetime,NOW()) ,0) AS minutes,state_gps_datetime,
           geofance_name")
        ->where('a.is_active','1') ; 
        if ($pool_code!='ALL') {
            $data=$data->where('a.pool_code',$pool_code);
        }
        if ($state=='Driving'){
            $data=$data->where('a.state_gps','Driving');
        } elseif ($state=='Parking'){
            $data=$data->where('a.state_gps','Parking');
        } elseif ($state=='Idle'){
            $data=$data->where('a.state_gps','Idle');
        } elseif ($state=='Update'){
            $data=$data->whereRaw("TIMESTAMPDIFF(HOUR,IFNULL(a.gps_last_update,'1899-12-31 00:00:00'),NOW())<24");
        } elseif ($state=='not-update') {
            $data=$data->whereRaw("TIMESTAMPDIFF(HOUR,IFNULL(a.gps_last_update,'1899-12-31 00:00:00'),NOW())>24");
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
        $data=$data->toArray();
        $rows=array();
        foreach($data['data'] as $row){
            $row['minutes_text']=PagesHelp::convert_minutes($row['minutes']);
            $rows[]=$row;
        }
        $data['data']=$rows;
        return response()->success('Success', $data);
    }

    public function gps_update(Request $request) {
        $data=Vehicles::selectRaw("vehicle_no,police_no,latitude,longitude,province,district,sub_district,
        last_address,ignation,speed,gps_last_update,pool_code,gps_vendor,IFNULL(gps_id,'') as gps_id,geofance_name,
        work_order_number,work_order_sysid,work_order_date,work_order_driver_id,work_order_driver_name")
        ->where("vehicle_no",isset($request->vehicle_no)? $request->vehicle_no:'')
        ->first();
        if ($data) {
            if ($data->gps_vendor=='EasyGo') {
                $url="https://vtsapi.easygo-gps.co.id/api/report/lastposition";
                $json=null;
                $form='{
                    "account_id": 0,
                    "vehicle_no": "",
                    "vehicle_code": ""
                    }';
                $log=PagesHelp::curl_data($url,$form,true,false,true);
                if ($log['status']===true){
                    $feedback=$log['json'];
                    if ($feedback) {
                        if ($feedback['ResponseCode']=='1'){
                            $json=$feedback['Data'];
                        } 
                    }
                }
                if ($json) {
                    foreach($json as $row) {
                        $date=substr($row['gps_time'],0,10);
                        $gps_time=date_format(date_create($date),'Y-m-d')." ".substr($row['gps_time'],11,8);
                        if ($row['gps_sn']==$data->gps_id) {                       
                            if (!($row['currentGeoAreaStatus']==null)) {
                                $geo=$row['currentGeoAreaStatus'];
                                $hotport=isset($geo['geo_nm']) ? $geo['geo_nm'] :'';
                            } else {
                                $hotport='';
                            }
                            $data->gps_last_update=$gps_time;
                            $data->latitude=$row['lat'];
                            $data->longitude=$row['lon'];
                            $data->province=isset($row['provinsi']) ? $row['provinsi'] :'';
                            $data->district=isset($row['kota']) ? $row['kota'] :'';
                            $data->sub_district=isset($row['kec']) ? $row['kec'] :'';
                            $data->last_address=$row['addr'];
                            $data->geofance_name=$hotport;
                            $data->ignation=($row['acc']=='1') ? 'On' : 'Off';
                            $data->speed=$row['speed'];
                            $data->state='Realtime EasyGo';
                        }    
                    }
                } 
            } elseif($data->gps_vendor=='TOTAL KILAT') {
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
                    foreach($json as $row) {
                        if ($data->gps_id==$row['device_id']) {
                            $data->gps_last_update=$row['gps_update'];
                            $data->latitude=$row['latitude'];
                            $data->longitude=$row['longitude'];
                            $data->province=isset($row['provinsi']) ? $row['provinsi'] :'';
                            $data->district=isset($row['kota']) ? $row['kota'] :'';
                            $data->sub_district=isset($row['kec']) ? $row['kec'] :'';
                            $data->last_address=isset($row['location']) ? $row['location'] :'';
                            $data->geofance_name=isset($row['hotport']) ? $row['hotport'] :'';
                            $data->ignation=$row['acc'];
                            $data->speed=$row['speed'];
                            $data->state='Realtime TOtal Kilat';

                        }
                    }; 
                }
            }
        }
        return response()->success('Success', $data);
    }
    public function get_operation(Request $request) {
        $sysid=isset($request->sysid) ? $request->sysid : '-1';
        $data=FleetOrder::from("t_fleet_order as a")
        ->selectRaw("a.transid,a.order_no,a.work_order_no,a.ref_date,a.origins,a.destination,a.vehicle_no,a.police_no,
        origins_geofance,destinations_geofance,
        DATE(a.origins_geofance_in) as origins_geofance_in,TIME(a.origins_geofance_in) as origins_geofance_in_time,
        DATE(a.origins_geofance_out) as origins_geofance_out,TIME(a.origins_geofance_out) as origins_geofance_out_time,
        DATE(a.destinations_geofance_in) as destinations_geofance_in,TIME(a.destinations_geofance_in) as destinations_geofance_in_time,
        DATE(a.destinations_geofance_out) as destinations_geofance_out,TIME(a.destinations_geofance_out) as destinations_geofance_out_time,
        a.driver_name,a.customer_name,b.partner_name,a.is_closed_order")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->where("transid",$sysid)->first();
        return response()->success('Success', $data);
    }

    public function post_operation(Request $request) {
        $info  = $request->json()->all();
        $row   = $info['data'];
        /*$valid=FleetOrder::find($row['transid']);
        if ($valid){
            if ($valid->is_closed_expense=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah registrasi biaya');
            } elseif ($valid->is_invoiced=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah terinvoice');
            }
        } else {
            return response()->error('',501,'Data kegiatan tidak ditemukan');
        }*/
        DB::beginTransaction();
        try {
            $data=FleetOrder::find($row['transid']);
            if (!($data->work_status=='Open')) {
                DB::rollback();
                return response()->error('',501,'Surat muatan order sudah selesai/dibatalkan');
            }
            if ($row['origins_geofance_in']) {
                $row['origins_geofance_in']=$row['origins_geofance_in'].' '.$row['origins_geofance_in_time'];
            }
            if ($row['origins_geofance_out']) {
                $row['origins_geofance_out']=$row['origins_geofance_out'].' '.$row['origins_geofance_out_time'];
            }
            if ($row['destinations_geofance_in']) {
                $row['destinations_geofance_in']=$row['destinations_geofance_in'].' '.$row['destinations_geofance_in_time'];
            }
            if ($row['destinations_geofance_out']) {
                $row['destinations_geofance_out']=$row['destinations_geofance_out'].' '.$row['destinations_geofance_out_time'];
            }
            if ($row['is_closed_order']=='1') {
                if ( (($row['origins_geofance_in'])==null) ||
                     (($row['origins_geofance_out'])==null) ||
                     (($row['destinations_geofance_in'])==null) ||
                     (($row['destinations_geofance_out']==null)) ) {
                    DB::rollback();
                    return response()->error('',501,'Tanggal & Jam muat dan bongkaran ada yang belum diisi');
                }
            } 
            FleetOrder::where('transid',$row['transid'])
            ->update([
                'origins_geofance'=>$row['origins_geofance'],
                'origins_geofance_in'=>$row['origins_geofance_in'],
                'origins_geofance_out'=>$row['origins_geofance_out'],
                'destinations_geofance'=>$row['destinations_geofance'],
                'destinations_geofance_in'=>$row['destinations_geofance_in'],
                'destinations_geofance_out'=>$row['destinations_geofance_out'],
                'is_closed_order'=>$row['is_closed_order']
            ]);
            if ($row['is_closed_order']=='1') {
                DB::update("UPDATE t_fleet_order SET duration=TIMESTAMPDIFF(HOUR,origins_geofance_out,destinations_geofance_in),
                            start_operation=origins_geofance_in,end_operation=destinations_geofance_out
                            WHERE transid=?",[$row['transid']]); 

                Vehicles::where('vehicle_no',$row['vehicle_no'])
                ->update([
                    'work_order_sysid'=>'-1',
                    'work_order_date'=>null,
                    'work_order_number'=>'',
                    'work_order_driver_id'=>'',
                    'work_order_driver_name'=>'',
                    'state_operation'=>'Free'
                ]);
            }
            PagesHelp::write_log($request,'Close Order',-1,$row['transid'],'Selesai Kegiatan '.$row['partner_name'].'-'.$row['work_order_no']);
            DB::commit();
            return response()->success('Success', "Update kegiatan berhasil");
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function spj(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $pool_code = isset($request->pool_code) ? $request->pool_code:'';
        $vehicle_group = isset($request->vehicle_group) ? $request->vehicle_group:'ALL';
        $all = isset($request->all) ? $request->all:'1';
        $date1 = isset($request->date1) ? $request->date1:'1899-12-31';
        $date2 = isset($request->date2) ? $request->date2:'1899-12-31';

        $data=FleetOrder::from("t_fleet_order as a")
        ->selectRaw("a.transid,a.ref_date,a.order_no,a.pool_code,a.work_order_no,a.customer_no,a.customer_no1,a.customer_no2,
            a.vehicle_no,a. police_no, a.employee_id,a.driver_name,a.work_order_type,IF((a.partner_id='2103'),CONCAT('COD (',a.customer_name,')'),b.partner_name) AS partner_name,
            a.origins,a.destination,a.warehouse,a.work_status,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,
            a.project_id,a.eta,a.duration,a.update_userid,a.update_timestamp,a.duration,a.eta,
            a.origins_geofance,a.origins_geofance_in,a.origins_geofance_out,a.vehicle_group,
            a.destinations_geofance,a.destinations_geofance_in,a.destinations_geofance_out,a.is_closed_order")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->join("m_vehicle as c","a.vehicle_no","=","c.vehicle_no")
        ->join("m_vehicle_group as d","a.vehicle_group","=","d.vehicle_type");
        if ($all=='0') {
            $data=$data->where('a.Work_status','Open');
        } else {
            $data=$data->where("a.ref_date",">=",$date1)
            ->where("a.ref_date","<=",$date2);
        } 
        if (!($pool_code=='ALL')) {
            $data=$data->where('a.pool_code',$pool_code);
        }
        if (!($vehicle_group=='ALL')) {
            $data=$data->where('d.main_group',$vehicle_group);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.order_no', 'like', $filter);
                $q->orwhere('a.work_order_no', 'like', $filter);
                $q->orwhere('a.vehicle_no', 'like', $filter);
                $q->orwhere('a.police_no', 'like', $filter);
                $q->orwhere('a.customer_no', 'like', $filter);
                $q->orwhere('b.partner_name', 'like', $filter);
                $q->orwhere('a.origins', 'like', $filter);
                $q->orwhere('a.destination', 'like', $filter);
                $q->orwhere('a.warehouse', 'like', $filter);
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
