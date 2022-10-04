<?php

namespace App\Http\Controllers\CS;

use App\Models\CS\CustomerOrder;
use App\Models\Master\VehicleVariableCost;
use App\Models\CS\StandartCostDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $outstanding = isset($request->outstanding) ? $request->outstanding:'0';
        $pool_code = isset($request->pool_code) ? $request->pool_code:'ALL';
        $all = isset($request->all) ? $request->all:'1';
        $date1 = isset($request->date1) ? $request->date1:'1899-12-31';
        $date2 = isset($request->date2) ? $request->date2:'1899-12-31';

        $data=CustomerOrder::from("t_customer_order as a")
        ->selectRaw("a.transid,a.order_no,a.entry_date,a.order_date,a.order_time,a.pool_code,a.partner_id,
        IF((a.partner_id='2103'),CONCAT('COD (',a.customer_name,')'),b.partner_name) AS partner_name,a.route_id,a.vehicle_type,a.origins,a.destination,a.warehouse,a.warehouse_destination,
        a.order_type,a.work_type,a.price,a.qty,a.standart_price,a.order_status,a.cost_id,a.fleet_cost,
        a.customer_no,a.planning_date,a.cancel_date,a.cancel_note,a.work_order_no,a.update_userid,a.update_timestamp,a.descriptions,
        c.ref_date as work_order_date,c.vehicle_no,c.police_no,c.driver_name,
        IFNULL(c.is_closed_order,0) as is_closed_order,IFNULL(c.is_closed_expense,0) as is_closed_expense")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->leftjoin("t_fleet_order as c","a.work_order_id","=","c.transid");
        if ($outstanding=='0'){
            $data=$data->where("a.order_date",">=",$date1)
            ->where("a.order_date","<=",$date2);

            if ($all=='0') {
                $data=$data->where('a.order_status','Open');
            }
        } else {
            $last_date=Date('Y-m-d', strtotime('-1000 days'));
            $data=$data->where('a.order_date','>=',$last_date)
                ->where('a.order_status','Open');
            if ($pool_code!='ALL') {
                $data=$data->where('a.pool_code',$pool_code);
            }    
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.order_no', 'like', $filter);
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

    public function delete(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data=CustomerOrder::find($transid);
        if ($data) {
            if (!($data->order_status=='Open')) {
                return response()->error('',501,'Reservasi order sudah diproses/dibatalkan');
            }
            DB::beginTransaction();
            try {
                $data->delete();
                DB::commit();
                return response()->success('Success','Reservasi order berhasil dihapus');
            } catch(Exception $error) {
                DB::rollback();    
            }    
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function cancel(Request $request){
        $validator=Validator::make($request->all(),
        [
            'transid'=>'bail|required',
            'reason'=>'bail|required',
        ],[
            'transid.required'=>'Nomor transaksi harus diisi',
            'reason.required'=>'Alasan pembatalan harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data=CustomerOrder::find($transid);
        if ($data) {
            if (!($data->order_status=='Open')) {
                return response()->error('',501,'Reservasi order sudah diproses/dibatalkan');
            }
            DB::beginTransaction();
            try {
                $data->update([
                    'order_status'=>'Cancel',
                    'cancel_date'=>Date('Y-m-d h:i:s'),
                    'cancel_note'=>$request->reason,
                    'cancel_userid'=>PagesHelp::UserID($request)
                ]);
                DB::commit();
                return response()->success('Success','Reservasi order berhasil dibatalkan');
            } catch(Exception $error) {
                DB::rollback();    
            }    
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data=CustomerOrder::from("t_customer_order as a")
        ->selectRaw("a.transid,a.order_no,a.entry_date,a.order_date,a.order_time,a.pool_code,a.partner_id,
        CONCAT(a.partner_id,' - ',IFNULL(b.partner_name,'')) as partner_name,a.route_id,a.vehicle_type,a.origins,a.destination,a.warehouse,a.warehouse_destination,
        a.order_type,a.work_type,a.price,a.qty,a.standart_price,a.order_status,a.cost_id,a.fleet_cost,a.customer_name,
        a.customer_no,DATE(a.planning_date) as planning_date,TIME(a.planning_date) as planning_time,a.cancel_date,a.work_order_no,descriptions,
        CONCAT(a.vehicle_type,' ( ',a.origins,' - ',a.destination,' )') as route_name,IFNULL(c.origins_geofance,'') as origins_geofance,
        IFNULL(c.destinations_geofance,'') as destinations_geofance,IFNULL(c.distance,0) as distance,IFNULL(c.eta,0) as eta")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->leftjoin("m_customer_price as c","a.route_id","=","c.id")
        ->where('a.transid',$transid)->first();
        $state=isset($request->state) ? $request->state :'order';
        if (($state=='order') && ($data)) {
            $cost_id=$data->cost_id;
            $data->cost=VehicleVariableCost::from('m_fleet_cost as a')
            ->selectRaw("a.id,a.descriptions,IFNULL(b.fleet_cost,0) as fleet_cost,a.is_fix,a.account_no")
            ->leftjoin("m_standart_fleet_cost2 as b",function($join) use($cost_id) {
                $join->on("a.id","=","b.id");
                $join->on("b.cost_id",DB::raw($cost_id));
            })
            ->where("a.is_active",'1')->get();
        }
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'pool_code'=>'bail|required',
            'order_date'=>'bail|required',
            'order_time'=>'bail|required',
            'order_type'=>'bail|required',
            'work_type'=>'bail|required',
            'partner_id'=>'bail|required',
            'vehicle_type'=>'bail|required',
            'route_id'=>'bail|required',
            'origins'=>'bail|required',
            'destination'=>'bail|required',
            'standart_price'=>'bail|required',
            'fleet_cost'=>'bail|required',
            'cost_id'=>'bail|required',
            'planning_date'=>'bail|required',
        ],[
            'pool_code.required'=>'Pool kendaraan harus diisi',
            'order_date.required'=>'Tanggal order harus diisi',
            'order_time.required'=>'Jam order harus diisi',
            'order_type.required'=>'Jenis order harus diisi',
            'work_type.required'=>'Jenis pekerjaan harus diisi',
            'partner_id.required'=>'Data konsumen harus diisi',
            'vehicle_type.required'=>'Jenis kendaraan harus diisi',
            'route_id.required'=>'Rute perjalanan harus diisi',
            'origins.required'=>'Asal perjalana harus diisi',
            'destination.required'=>'Tujuan perjalana harus diisi',
            'standart_price.required'=>'Tarif kegiatan harus diisi',
            'fleet_cost.required'=>'Biaya standar harus diisi',
            'cost_id.required'=>'Kode biaya harus diisi',
            'planning_date.required'=>'Tanggal rencana operasi harus diisi'
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        if (($row['partner_id']=='2103') && ($row['customer_name']=='')) {
            return response()->error('',501,'Untuk COD harus diisi nama customer-nya');
        }
        DB::beginTransaction();
        try {
            $data=CustomerOrder::find($row['transid']);
            if ($data){
                if (!($data->order_status=='Open')) {
                    DB::rollback();
                    return response()->error('',501,'Reservasi order sudah diproses/dibatalkan');
                }
                $transid=$row['transid'];
                $data->update([
                    'order_date'=>$row['order_date'],
                    'order_time'=>$row['order_time'],
                    'pool_code'=>$row['pool_code'],
                    'partner_id'=>$row['partner_id'],
                    'customer_name'=>$row['customer_name'],
                    'vehicle_type'=>$row['vehicle_type'],
                    'origins'=>$row['origins'],
                    'destination'=>$row['destination'],
                    'route_id'=>$row['route_id'],
                    'warehouse'=>$row['warehouse'],
                    'warehouse_destination'=>$row['warehouse_destination'],
                    'work_type'=>$row['work_type'],
                    'order_type'=>$row['order_type'],
                    'price'=>$row['price'],
                    'qty'=>$row['qty'],
                    'standart_price'=>$row['standart_price'],
                    'cost_id'=>$row['cost_id'],
                    'fleet_cost'=>$row['fleet_cost'],
                    'order_status'=>'Open',
                    'descriptions'=>$row['descriptions'],
                    'customer_no'=>$row['customer_no'],
                    'entry_date'=>Date('Y-m-d'),
                    'is_transactionlink'=>'0',
                    'planning_date'=>$row['planning_date'].' '.$row['planning_time'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
           } else {
                $order_no= CustomerOrder::GenerateNumber($row['order_date']);
                $transid=CustomerOrder::max('transid');
                $transid=intval($transid)+1;

                CustomerOrder::insert([
                    'transid'=>$transid,
                    'order_no'=>$order_no,
                    'order_date'=>$row['order_date'],
                    'order_time'=>$row['order_time'],
                    'pool_code'=>$row['pool_code'],
                    'partner_id'=>$row['partner_id'],
                    'customer_name'=>$row['customer_name'],
                    'vehicle_type'=>$row['vehicle_type'],
                    'origins'=>$row['origins'],
                    'destination'=>$row['destination'],
                    'route_id'=>$row['route_id'],
                    'warehouse'=>$row['warehouse'],
                    'warehouse_destination'=>$row['warehouse_destination'],
                    'work_type'=>$row['work_type'],
                    'order_type'=>$row['order_type'],
                    'price'=>$row['price'],
                    'qty'=>$row['qty'],
                    'standart_price'=>$row['standart_price'],
                    'cost_id'=>$row['cost_id'],
                    'fleet_cost'=>$row['fleet_cost'],
                    'order_status'=>'Open',
                    'descriptions'=>$row['descriptions'],
                    'customer_no'=>$row['customer_no'],
                    'entry_date'=>Date('Y-m-d'),
                    'is_transactionlink'=>'0',
                    'planning_date'=>$row['planning_date'].' '.$row['planning_time'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            if (isset($row['order_qty'])) {
                if ($row['order_qty']>=2) {
                    $copy=CustomerOrder::where('transid',$transid)->first();
                    for ($i=1;$i<floatval($row['order_qty']);$i++){
                        $newid=CustomerOrder::max('transid');
                        $newid=intval($newid)+1;
                        $copy->transid=$newid;
                        $copy->order_no=CustomerOrder::GenerateNumber($copy->order_date);
                        $copy->update_timestamp=Date('Y-m-d H:i:s');
                        CustomerOrder::insert([
                            'transid'=>$copy->transid,
                            'order_no'=>$copy->order_no,
                            'order_date'=>$copy->order_date,
                            'order_time'=>$copy->order_time,
                            'pool_code'=>$copy->pool_code,
                            'partner_id'=>$copy->partner_id,
                            'customer_name'=>$copy->customer_name,
                            'vehicle_type'=>$copy->vehicle_type,
                            'origins'=>$copy->origins,
                            'destination'=>$copy->destination,
                            'route_id'=>$copy->route_id,
                            'warehouse'=>$copy->warehouse,
                            'warehouse_destination'=>$copy->warehouse_destination,
                            'work_type'=>$copy->work_type,
                            'order_type'=>$copy->order_type,
                            'price'=>$copy->price,
                            'qty'=>$copy->qty,
                            'standart_price'=>$copy->standart_price,
                            'cost_id'=>$copy->cost_id,
                            'fleet_cost'=>$copy->fleet_cost,
                            'order_status'=>'Open',
                            'descriptions'=>$copy->descriptions,
                            'customer_no'=>$copy->customer_no,
                            'entry_date'=>Date('Y-m-d'),
                            'is_transactionlink'=>'0',
                            'planning_date'=>$copy->planning_date,
                            'update_userid'=>PagesHelp::UserID($request),
                            'update_timestamp'=>Date('Y-m-d h:i:s')
                        ]);
                    }
                }
            }
            PagesHelp::write_log($request,'Reserveri Order',-1,$transid,'Reservasi order '.$row['partner_id'].'-'.$row['destination']);
            DB::commit();
            return response()->success('Success','Reservasi order berhasil dibuat/diupdate');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function getlist(Request $request){
        $data=CustomerOrder::selectRaw("id,descriptions,account_name,account_number")
            ->where('is_active','1')
            ->orderBy('id','asc')->get();
        return response()->success('Success',$data);
    }
}
