<?php

namespace App\Http\Controllers\Operation;

use App\Models\Operation\FleetOrder;
use App\Models\Operation\FleetOrderCost;
use App\Models\Operation\FleetOrderRowCost;
use App\Models\Operation\FleetExpense1;
use App\Models\Operation\FleetExpense2;
use App\Models\CS\CustomerOrder;
use App\Models\CS\StandartCostDetail;
use App\Models\Master\Personal;
use App\Models\Master\Vehicles;
use App\Models\Accounting\Journal1;
use App\Models\Accounting\Journal2;
use App\Models\Accounting\GeneralAcc;
use App\Models\Master\VehicleVariableCost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;
use Accounting;
use PDF;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OperationController extends Controller
{
    public function index(Request $request)
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
            a.origins,a.destination,a.warehouse,a.price,a.real_tonase,a.tonase,a.net_price,
            a.other_bill,a.over_night,a.total,a.budget,a.expense,a.dp_customer,a.work_status,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,
            a.standart_fleet_cost,a.project_id,a.eta,a.duration,a.update_userid,a.update_timestamp,
            a.origins_geofance,a.origins_geofance_in,a.origins_geofance_out,a.vehicle_group,
            a.destinations_geofance,a.destinations_geofance_in,a.destinations_geofance_out")
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

    public function delete(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data=FleetOrder::find($transid);
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

    public function get(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data['data']=FleetOrder::from('t_fleet_order as a')
        ->selectRaw("a.transid,a.ref_date,a.order_no,a.pool_code,a.work_order_no,a.customer_no,a.customer_no1,a.customer_no2,
            a.vehicle_no,a.police_no,a.driver_id,a.employee_id,a.driver_name,a.work_order_type,a.partner_id,CONCAT(a.partner_id,' - ',b.partner_name) as partner_name,
            a.origins,a.destination,a.warehouse,a.price,a.minimal_tonase,a.real_tonase,a.tonase,a.net_price,a.order_instructions,
            a.other_bill,a.over_night,a.total,a.budget,a.dp_customer,a.work_status,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,
            a.standart_fleet_cost,a.project_id,a.eta,a.duration,a.origins_geofance,a.origins_geofance_in,a.origins_geofance_out,
            a.destinations_geofance,a.destinations_geofance_in,a.destinations_geofance_out,a.vehicle_group,a.work_type,a.project_id,
            a.cost_id,IFNULL(a.customer_no1,'') as customer_no1,IFNULL(a.customer_no2,'') as customer_no2,a.customer_name,a.eta")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->leftjoin("m_vehicle as c","a.vehicle_no","=","c.vehicle_no")
        ->where('a.transid',$transid)->first();
        if ($data['data']){
            $data['cost']=FleetExpense1::selectRaw("transid,doc_number,ref_date,dp_customer,total,cashier,dp_method")
            ->where("fleet_orderid",$data['data']->transid)
            ->where("is_primary",'1')->first();
            $data['costs']=FleetExpense2::from('t_fleet_expense2 as a')
            ->selectRaw("a.transid,a.line_no,a.expense_code,a.descriptions,a.standart_budget,a.expense_budget,b.is_fix,
              IFNULL(b.account_no,'') as account_no,IFNULL(a.line_note,'') as line_note")
            ->join("m_fleet_cost as b","a.expense_code","=","b.id")
            ->where("a.transid",$data['cost']->transid)->get();
        }
        return response()->success('Success',$data);
    }

    public function get2(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data['data']=FleetOrder::from('t_fleet_order as a')
        ->selectRaw("a.transid,a.ref_date,a.order_no,a.pool_code,a.work_order_no,a.customer_no,a.customer_no1,a.customer_no2,
            a.vehicle_no,a.police_no,a.driver_id,a.employee_id,a.driver_name,a.work_order_type,a.partner_id,CONCAT(a.partner_id,' - ',b.partner_name) as partner_name,
            a.origins,a.destination,a.warehouse,a.price,a.minimal_tonase,a.real_tonase,a.tonase,a.net_price,a.order_instructions,
            a.other_bill,a.over_night,a.total,a.budget,a.dp_customer,a.work_status,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,
            a.standart_fleet_cost,a.project_id,a.eta,a.duration,a.origins_geofance,a.origins_geofance_in,a.origins_geofance_out,
            a.destinations_geofance,a.destinations_geofance_in,a.destinations_geofance_out,a.vehicle_group,a.work_type,a.project_id,
            a.cost_id,IFNULL(a.customer_no1,'') as customer_no1,IFNULL(a.customer_no2,'') as customer_no2,a.customer_name,a.eta")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->leftjoin("m_vehicle as c","a.vehicle_no","=","c.vehicle_no")
        ->where('a.transid',$transid)->first();
        if ($data['data']){
            $data['cost']=FleetExpense1::selectRaw("transid,doc_number,fleet_orderid,fleet_order_no,ref_date,standart,dp_customer,total,cashier,dp_method,account_no,
            account_name,other_expense,CONCAT(trans_code,'-',trans_series) as voucher,no_jurnal,is_authorize,authorize_userid,authorize_date,
            is_canceled,canceled_date,canceled_by,cash_amount")
            ->where("fleet_orderid",$data['data']->transid)->get();
        }
        return response()->success('Success',$data);
    }

    public function get3(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        $data['data']=FleetOrder::from('t_fleet_order as a')
        ->selectRaw("a.transid,a.ref_date,a.order_no,a.pool_code,a.work_order_no,a.customer_no,a.customer_no1,a.customer_no2,
            a.vehicle_no,a.police_no,a.driver_id,a.employee_id,a.driver_name,a.work_order_type,a.partner_id,CONCAT(a.partner_id,' - ',b.partner_name) as partner_name,
            a.origins,a.destination,a.warehouse,a.price,a.minimal_tonase,a.real_tonase,a.tonase,a.net_price,a.order_instructions,
            a.other_bill,a.over_night,a.total,a.budget,a.dp_customer,a.work_status,CONCAT(a.trans_code,'-',a.trans_series) AS voucher,
            a.standart_fleet_cost,a.project_id,a.eta,a.duration,a.origins_geofance,a.origins_geofance_in,a.origins_geofance_out,
            a.destinations_geofance,a.destinations_geofance_in,a.destinations_geofance_out,a.vehicle_group,a.work_type,a.project_id,
            a.cost_id,IFNULL(a.customer_no1,'') as customer_no1,IFNULL(a.customer_no2,'') as customer_no2,a.cost_date,a.customer_name,a.eta")
        ->leftjoin("m_partner as b","a.partner_id","=","b.partner_id")
        ->leftjoin("m_vehicle as c","a.vehicle_no","=","c.vehicle_no")
        ->where('a.transid',$transid)->first();
        if ($data['data']){
            if (FleetOrderCost::where('transid',$transid)->exists()) {
                $data['costs']=FleetOrderCost::selectRaw("transid,line_no,expense_code,descriptions,standar_budget,budget,expense,notes,
                is_invoice,acuan,base_cost,qty,percent_cost,fee")
                ->where('transid',$transid)->get();
            } else {
                $data['entered']='Entered';
                $costs=FleetExpense1::from('t_fleet_expense1 as a')
                ->selectRaw("b.expense_code,b.descriptions,SUM(standart_budget) AS standart_budget,SUM(expense_budget) AS expense_budget")
                ->join("t_fleet_expense2 as b","a.transid","=","b.transid")
                ->where("a.fleet_orderid",$transid)                 
                ->groupBy(DB::raw('b.expense_code,b.descriptions'))                 
                ->get();
                $number=0;
                foreach ($costs as $line){
                    $number=$number + 1;
                    $row=array();
                    $row['transid']=intval($transid);    
                    $row['line_no']=$number;    
                    $row['expense_code']=$line['expense_code'];    
                    $row['descriptions']=$line['descriptions'];    
                    $row['standar_budget']=floatval($line['standart_budget']);    
                    $row['budget']=floatval($line['expense_budget']);    
                    $row['expense']=floatval($line['expense_budget']);    
                    $row['is_invoice']='0';
                    $row['notes']='';    
                    $row['acuan']='COST';    
                    $row['base_cost']=0;    
                    $row['qty']=0;    
                    $row['percent_cost']=0;    
                    $row['fee']=0;    
                    $data['costs'][]=$row;
                }
            }
        }
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info  = $request->json()->all();
        $row   = $info['data'];
        $cost  = $info['cost'];
        $costs = $info['variable'];
        $validator=Validator::make($row,
        [
            'ref_date'=>'bail|required',
            'order_no'=>'bail|required',
            'project_id'=>'bail|required',
            'pool_code'=>'bail|required',
            'vehicle_no'=>'bail|required',
            'vehicle_group'=>'bail|required',
            'police_no'=>'bail|required',
            'driver_id'=>'bail|required',
            'employee_id'=>'bail|required',
            'work_order_type'=>'bail|required',
            'work_type'=>'bail|required',
            'partner_id'=>'bail|required',
            'origins'=>'bail|required',
            'destination'=>'bail|required',
            'warehouse'=>'bail|required',
            'tonase'=>'bail|min:1'
        ],[
            'ref_date.required'=>'Tanggal kegiatan harus diisi',
            'project_id.required'=>'Tipe proyek harus diisi',
            'pool_code.required'=>'Pool kendaraan harus diisi',
            'order_no.required'=>'Nomor reservasi harus diisi',
            'vehicle_no.required'=>'Nomor unit harus diisi',
            'vehicle_group.required'=>'Jenis unit harus diisi',
            'police_no.required'=>'No. Polisi harus diisi',
            'driver_id.required'=>'ID Pengemudi harus diisi',
            'employee_id.required'=>'NIK Pengemudi harus diisi',
            'work_order_type.required'=>'Tipe pekerjaan harus diisi',
            'work_type.required'=>'Jenis pekerjaan harus diisi',
            'partner_id.required'=>'Konsumen harus diisi',
            'origins.required'=>'Asal harus diisi',
            'destination.required'=>'Tujuan harus diisi',
            'warehouse.required'=>'Gudang/Pabrik muat harus diisi',
            'tonase.min'=>'Tonase tidak boleh lebih kecil dari 1'
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        $row['standart_fleet_cost']=0;
        $cost['total']=0;
        foreach($costs as $line){
            $row['standart_fleet_cost']=$row['standart_fleet_cost']+$line['standart_budget'];
            $cost['total']=$cost['total']+$line['expense_budget'];
        }
        if ($cost['dp_method'] == 'DITERIMA SUPIR') {
            $cost['cashier'] = $cost['total'] - $cost['dp_customer'];
        } else {
            $cost['cashier'] = $cost['total'];
        }
        $valid=FleetOrder::find($row['transid']);
        if ($valid){
            if ($valid->is_closed_order=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah ditutup');
            } elseif ($valid->is_closed_expense=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah registrasi biaya');
            } elseif ($valid->is_invoiced=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah terinvoice');
            }
            if (FleetExpense1::where("fleet_orderid",$valid->transid)
              ->whereRaw("IFNULL(cash_amount,0)>0")->exists()){
                return response()->error('',501,'LBO untuk surat muatan ini sudah diproses kasir');
              }
        }
        $valid=FleetOrder::where('driver_id',$row['driver_id'])
        ->whereRaw("((budget-expense) > 0) AND IFNULL(is_posted_ar,0)=0 AND work_status<>'Open' AND ref_date >='2016-01-01'")->first();
        if ($valid) {
            return response()->error('',501,'SUrat Muat :'.$valid->work_order_no.' terdapat selisih biaya operasional');
        }

        DB::beginTransaction();
        try {
            $driver=Personal::selectRaw("personal_name")->where('employee_id',$row['employee_id'])->first();
            $data=FleetOrder::find($row['transid']);
            if ($data){
                if (!($data->work_status=='Open')) {
                    DB::rollback();
                    return response()->error('',501,'Surat muatan order sudah diproses/dibatalkan');
                }
                CustomerOrder::where('order_no',$row['order_no'])
                ->update([
                    'work_order_id'=>'-1',
                    'work_order_no'=>'',
                    'work_order_date'=>null,
                    'is_transactionlink'=>'0',
                    'order_status'=>'Open'
                ]);
                Vehicles::where('vehicle_no',$row['vehicle_no'])
                ->update([
                    'work_order_sysid'=>'-1',
                    'work_order_date'=>null,
                    'work_order_number'=>'',
                    'work_order_driver_id'=>'',
                    'work_order_driver_name'=>''
                ]);

                $transid=$row['transid'];
                $work_order_no=$data->work_order_no;
                $data->update([
                    'ref_date'=>$row['ref_date'],
                    'order_no'=>$row['order_no'],
                    'pool_code'=>$row['pool_code'],
                    'customer_no'=>$row['customer_no'],
                    'customer_no1'=>$row['customer_no1'],
                    'customer_no2'=>$row['customer_no2'],
                    'vehicle_no'=>$row['vehicle_no'],
                    'vehicle_group'=>$row['vehicle_group'],
                    'police_no'=>$row['police_no'],
                    'chasis_no'=>'-',
                    'driver_id'=>$row['driver_id'],
                    'employee_id'=>$row['employee_id'],
                    'driver_name'=>isset($driver->personal_name) ? $driver->personal_name :'',
                    'work_order_type'=>$row['work_order_type'],
                    'work_type'=>$row['work_type'],
                    'partner_id'=>$row['partner_id'],
                    'customer_name'=>$row['customer_name'],
                    'eta'=>$row['eta'],
                    'origins'=>$row['origins'],
                    'destination'=>$row['destination'],
                    'warehouse'=>$row['warehouse'],
                    'order_instructions'=>$row['order_instructions'],
                    'price'=>$row['price'],
                    'minimal_tonase'=>$row['minimal_tonase'],
                    'real_tonase'=>$row['real_tonase'],
                    'tonase'=>$row['tonase'],
                    'net_price'=>$row['net_price'],
                    'other_bill'=>$row['other_bill'],
                    'over_night'=>$row['over_night'],
                    'total'=>$row['total'],
                    'work_status'=>'Open',
                    'cost_id'=>$row['cost_id'],
                    'origins_geofance'=>$row['origins_geofance'],
                    'destinations_geofance'=>$row['destinations_geofance'],
                    'is_closed_order'=>'0',
                    'is_closed_expense'=>'0',
                    'expense_id'=>'-1',
                    'no_jurnal'=>'-1',
                    'trans_code'=>'',
                    'trans_series'=>'',
                    'project_id'=>$row['project_id'],
                    'standart_fleet_cost'=>$row['standart_fleet_cost'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
           } else {
                $work_order_no=FleetOrder::Generate($row['pool_code'],$row['ref_date']);
                $transid=FleetOrder::insertGetId([
                    'ref_date'=>$row['ref_date'],
                    'order_no'=>$row['order_no'],
                    'pool_code'=>$row['pool_code'],
                    'work_order_no'=>$work_order_no,
                    'customer_no'=>$row['customer_no'],
                    'customer_no1'=>$row['customer_no1'],
                    'customer_no2'=>$row['customer_no2'],
                    'vehicle_no'=>$row['vehicle_no'],
                    'vehicle_group'=>$row['vehicle_group'],
                    'police_no'=>$row['police_no'],
                    'chasis_no'=>'-',
                    'driver_id'=>$row['driver_id'],
                    'employee_id'=>$row['employee_id'],
                    'driver_name'=>isset($driver->personal_name) ? $driver->personal_name :'',
                    'work_order_type'=>$row['work_order_type'],
                    'work_type'=>$row['work_type'],
                    'partner_id'=>$row['partner_id'],
                    'customer_name'=>$row['customer_name'],
                    'eta'=>$row['eta'],
                    'origins'=>$row['origins'],
                    'destination'=>$row['destination'],
                    'warehouse'=>$row['warehouse'],
                    'order_instructions'=>$row['order_instructions'],
                    'price'=>$row['price'],
                    'minimal_tonase'=>$row['minimal_tonase'],
                    'real_tonase'=>$row['real_tonase'],
                    'tonase'=>$row['tonase'],
                    'net_price'=>$row['net_price'],
                    'other_bill'=>$row['other_bill'],
                    'over_night'=>$row['over_night'],
                    'total'=>$row['total'],
                    'work_status'=>'Open',
                    'cost_id'=>$row['cost_id'],
                    'is_closed_order'=>'0',
                    'is_closed_expense'=>'0',
                    'expense_id'=>'-1',
                    'no_jurnal'=>'-1',
                    'trans_code'=>'',
                    'trans_series'=>'',
                    'project_id'=>$row['project_id'],
                    'standart_fleet_cost'=>$row['standart_fleet_cost'],
                    'origins_geofance'=>$row['origins_geofance'],
                    'destinations_geofance'=>$row['destinations_geofance'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            $order=CustomerOrder::where('order_no',$row['order_no'])->first();
            if ($order){
                if ($order->order_status<>'Open'){
                    DB::rollback();    
                    return response()->error('',501,'Nomor reservasi :'.$row['order_no'].' sudah diproses');
                }
            }

            $cost_table=FleetExpense1::selectRaw("transid,fleet_orderid")
            ->where('fleet_orderid',$transid)->first();
            if (!($cost_table)) {
                $sysid=FleetExpense1::insertGetId([
                    'doc_number'=>$work_order_no.'-1',
                    'ref_date'=>$row['ref_date'],
                    'fleet_orderid'=>$transid,
                    'fleet_order_no'=>$work_order_no,
                    'is_primary'=>'1',
                    'pool_code'=>$row['pool_code'],
                    'cash_id'=>'-1',
                    'is_authorize'=>'1',
                    'is_closed'=>'0',
                    'authorize_userid'=>'SYSTEM',    
                    'authorize_date'=>Date('Y-m-d H:i:s'),
                    'standart'=>$row['standart_fleet_cost'],
                    'other_expense'=>0,
                    'standart'=>$row['standart_fleet_cost'],
                    'dp_valid'=>($cost['dp_method']=='TRANSFER') ? '0' : '1', 
                    'project_id'=>$row['project_id'],
                    'dp_customer'=>$cost['dp_customer'],
                    'total'=>$cost['total'],
                    'cashier'=>$cost['cashier'],
                    'dp_method'=>$cost['dp_method'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            } else {
                if ($cost_table->is_closed=='1') {
                    DB::rollback();    
                    return response()->error('',501,'LBO ini sudah dilakukan pengeluaran dananya oleh kasir');
                }
                $sysid=$cost_table->transid;
                FleetExpense1::where('transid',$sysid)
                ->update([
                    'doc_number'=>$work_order_no.'-1',
                    'ref_date'=>$row['ref_date'],
                    'fleet_orderid'=>$transid,
                    'fleet_order_no'=>$work_order_no,
                    'is_primary'=>'1',
                    'pool_code'=>$row['pool_code'],
                    'cash_id'=>'-1',
                    'is_authorize'=>'1',
                    'is_closed'=>'0',
                    'authorize_userid'=>'SYSTEM',    
                    'authorize_date'=>Date('Y-m-d H:i:s'),
                    'standart'=>$row['standart_fleet_cost'],
                    'other_expense'=>0,
                    'dp_valid'=>($cost['dp_method']=='TRANSFER') ? '0' : '1', 
                    'project_id'=>$row['project_id'],
                    'dp_customer'=>$cost['dp_customer'],
                    'total'=>$cost['total'],
                    'cashier'=>$cost['cashier'],
                    'dp_method'=>$cost['dp_method'],
                    'project_id'=>$row['project_id'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            }
            FleetExpense2::where('transid',$sysid)->delete();
            foreach($costs as $line) {
                FleetExpense2::insert([
                    'transid'=>$sysid,
                    'line_no'=>$line['line_no'],
                    'expense_code'=>$line['expense_code'],
                    'descriptions'=>$line['descriptions'],
                    'account_no'=>$line['account_no'],
                    'standart_budget'=>$line['standart_budget'],
                    'expense_budget'=>$line['expense_budget'],
                    'line_note'=>$line['line_note']
                ]);
            }
            CustomerOrder::where('order_no',$row['order_no'])
            ->update([
                'work_order_id'=>$transid,
                'work_order_no'=>$work_order_no,
                'work_order_date'=>$row['ref_date'],
                'is_transactionlink'=>'1',
                'order_status'=>'Close'
            ]);
            Vehicles::where('vehicle_no',$row['vehicle_no'])
            ->update([
                'work_order_sysid'=>$transid,
                'work_order_date'=>$row['ref_date'],
                'work_order_number'=>$work_order_no,
                'work_order_driver_id'=>$row['employee_id'],
                'work_order_driver_name'=>isset($driver->personal_name) ? $driver->personal_name :''
            ]);

            PagesHelp::write_log($request,'Plannning Order',-1,$transid,'Planning order '.$row['partner_id'].'-'.$row['destination']);
            DB::commit();
            $respon['doc_sysid']=$transid;
            $respon['lbo_sysid']=$sysid;
            $respon['message']="Planning order/surat muatan berhasil dibuat";

            return response()->success('Success',$respon);
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function getlist(Request $request){
        $data=FleetOrder::selectRaw("id,descriptions,account_name,account_number")
            ->where('is_active','1')
            ->orderBy('id','asc')->get();
        return response()->success('Success',$data);
    }

    public function get_lbo(Request $request){
        $transid=isset($request->transid) ? $request->transid :'-1';
        if (isset($request->fleetorderid)) {
            $oprs=FleetOrder::selectRaw("cost_id")->where('transid',$request->fleetorderid)->first();
            $cost_id=$oprs->cost_id;
            $costs=VehicleVariableCost::from('m_fleet_cost as a')
            ->selectRaw("a.id as expense_code,a.descriptions,0 as standart_budget,0 as expense_budget,
            a.is_fix,a.account_no,'' as line_note")
            ->leftjoin("m_standart_fleet_cost2 as b",function($join) use($cost_id) {
                $join->on("a.id","=","b.id");
                $join->on("b.cost_id",DB::raw($cost_id));
            })
            ->where("a.is_active",'1')->get();
            $data['costs']=array();
            $line=0;
            foreach ($costs as $cost) {
                $line++;
                $cost->line_no=$line;
                $data['costs'][]=$cost;
            }
        } else {
            $data['cost']=FleetExpense1::selectRaw("transid,doc_number,ref_date,fleet_orderid,fleet_order_no,dp_customer,total,cashier,dp_method,is_primary")
            ->where("transid",$transid)->first();
            $data['costs']=FleetExpense2::from('t_fleet_expense2 as a')
            ->selectRaw("a.transid,a.line_no,a.expense_code,a.descriptions,a.standart_budget,a.expense_budget,b.is_fix,
                IFNULL(b.account_no,'') as account_no,IFNULL(a.line_note,'') as line_note")
            ->join("m_fleet_cost as b","a.expense_code","=","b.id")
            ->where("a.transid",$transid)->get();
        }
        return response()->success('Success',$data);
    }

    public function post_lbo(Request $request){
        $info  = $request->json()->all();
        $cost  = $info['cost'];
        $costs = $info['variable'];
        $is_authorize=isset($info['is_authorize']) ? $info['is_authorize'] :'0';
        $validator=Validator::make($cost,
        [
            'ref_date'=>'bail|required',
            'fleet_orderid'=>'bail|required',
        ],[
            'ref_date.required'=>'Tanggal kegiatan harus diisi',
            'fleet_orderid.required'=>'Nomor surat muatan harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        $row['standart_fleet_cost']=0;
        $cost['total']=0;
        foreach($costs as $line){
            $cost['total']=$cost['total']+$line['expense_budget'];
        }
        $cost['cashier'] = $cost['total'];
        if ($cost['is_primary']=='1') {
            return response()->error('',501,'LBO ini tidak bisa diproses lewat menu ini');
        }

        $oprs=FleetOrder::find($cost['fleet_orderid']);
        if ($oprs){
            if ($oprs->is_closed_order=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah ditutup');
            } elseif ($oprs->is_closed_expense=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah registrasi biaya');
            } elseif ($oprs->is_invoiced=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah terinvoice');
            }
        } else {
            return response()->error('',501,'Kegiatan operasi tidak ditemukan');
        }
        if ($is_authorize=='1') {
            DB::beginTransaction();
            try {
                $expense=FleetExpense1::find($cost['transid']);
                if ($expense){
                    if ($expense->is_closed=='1') {
                        DB::rollback();    
                        return response()->error('',501,'LBO sudah diproses kasir');
                    } elseif ($expense->is_authorize=='1') {
                        DB::rollback();    
                        return response()->error('',501,'LBO sudah diotorisasi');
                    } elseif ($expense->is_canceled=='1') {
                        DB::rollback();    
                        return response()->error('',501,'LBO sudah dibatalkan');
                    }
                    $expense->update([
                        'is_authorize'=>'1',
                        'authorize_userid'=>PagesHelp::UserID($request),
                        'authorize_date'=>Date('Y-m-d H:i:s')
                    ]);
                    PagesHelp::write_log($request,'LBO Verified',-1,$cost['transid'],'LBO '.$expense->doc_number);
                    DB::commit();
                    return response()->success('Success','Otorisasi LBO berhasil');
                } else {
                    DB::rollback();    
                    return response()->error('',501,'Data pengajuan biaya tidak ditemukan');
                }
            } catch(Exception $error) {
                DB::rollback();    
            }    
        }

        DB::beginTransaction();
        try {
            $cost_table=FleetExpense1::selectRaw("transid,fleet_orderid,is_primary,is_canceled,is_authorize")
            ->where('transid',$cost['transid'])->first();
            if (!($cost_table)) {
                $counter=FleetExpense1::where('fleet_orderid',$cost['fleet_orderid'])->count();
                $counter=$counter + 1;
                $sysid=FleetExpense1::insertGetId([
                    'doc_number'=>$cost['work_order_no'].'-'.$counter,
                    'ref_date'=>$cost['ref_date'],
                    'fleet_orderid'=>$oprs->transid,
                    'fleet_order_no'=>$oprs->work_order_no,
                    'is_primary'=>'0',
                    'pool_code'=>$oprs->pool_code,
                    'cash_id'=>'-1',
                    'is_authorize'=>'0',
                    'is_closed'=>'0',
                    'authorize_userid'=>'',    
                    'other_expense'=>0,
                    'dp_valid'=>'1', 
                    'project_id'=>$oprs->project_id,
                    'dp_customer'=>'0',
                    'total'=>$cost['total'],
                    'cashier'=>$cost['cashier'],
                    'dp_method'=>'-',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            } else {
                if ($cost_table->is_closed=='1') {
                    DB::rollback();    
                    return response()->error('',501,'LBO ini sudah dilakukan pengeluaran dananya oleh kasir,tidak bisa diubah');
                } elseif ($cost_table->is_authorize=='1') {
                    DB::rollback();    
                    return response()->error('',501,'LBO ini sudah diotorisasi,tidak bisa diubah');
                } elseif ($cost_table->is_canceled=='1') {
                    DB::rollback();    
                    return response()->error('',501,'LBO ini sudah dibatalkan,tidak bisa diubah');
                }
                $sysid=$cost_table->transid;
                FleetExpense1::where('transid',$sysid)
                ->update([
                    'ref_date'=>$cost['ref_date'],
                    'fleet_orderid'=>$oprs->transid,
                    'fleet_order_no'=>$oprs->work_order_no,
                    'is_primary'=>'0',
                    'pool_code'=>$oprs->pool_code,
                    'cash_id'=>'-1',
                    'is_authorize'=>'0',
                    'is_closed'=>'0',
                    'authorize_userid'=>'',    
                    'other_expense'=>0,
                    'dp_valid'=>'1', 
                    'project_id'=>$oprs->project_id,
                    'dp_customer'=>'0',
                    'total'=>$cost['total'],
                    'cashier'=>$cost['cashier'],
                    'dp_method'=>'-',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            }
            FleetExpense2::where('transid',$sysid)->delete();
            foreach($costs as $line) {
                FleetExpense2::insert([
                    'transid'=>$sysid,
                    'line_no'=>$line['line_no'],
                    'expense_code'=>$line['expense_code'],
                    'descriptions'=>$line['descriptions'],
                    'account_no'=>$line['account_no'],
                    'standart_budget'=>$line['standart_budget'],
                    'expense_budget'=>$line['expense_budget'],
                    'line_note'=>isset($line['line_note']) ? $line['line_note'] :''
                ]);
            }
            PagesHelp::write_log($request,'LBO',-1,$sysid,'LBO '.$oprs->partner_id);
            DB::commit();
            return response()->success('Success','Permintaan biaya operasional tambahan berhasil dibuat');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function post_closedlbo(Request $request){
        $info  = $request->json()->all();
        $data  = $info['data'];
        $costs = $info['variable'];
        $validator=Validator::make($data,
        [
            'ref_date'=>'bail|required',
            'cost_date'=>'bail|required',
            'work_order_no'=>'bail|required',
        ],[
            'ref_date.required'=>'Tanggal kegiatan harus diisi',
            'cost_date.required'=>'Tanggal selesai kegiatan harus diisi',
            'work_order_no.required'=>'Nomor surat muatan harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }

        $data['expense']=0;
        $data['fee']=0;
        $data['budget']=0;
        foreach($costs as $line){
            $data['fee']    = $data['fee']     + $line['fee'];
            $data['expense']= $data['expense'] + $line['expense'];
            $data['budget'] = $data['budget'] + $line['budget'];
        }
        $oprs=FleetOrder::find($data['transid']);
        if ($oprs){
            if ($oprs->is_invoiced=='1'){
                return response()->error('',501,'Surat muatan/kegiatan ini sudah terinvoice');
            }
        } else {
            return response()->error('',501,'Kegiatan operasi tidak ditemukan');
        }
        $cost_check=FleetExpense1::where('fleet_orderid',$data['transid'])
        ->where('is_closed','0')
        ->where('is_canceled','0')->first();
        if ($cost_check) {
            return response()->error('',501,'No. LBO '.$cost_check->doc_number.' belum diproses kasir');
        }
        DB::beginTransaction();
        try {
            FleetOrderCost::where('transid',$data['transid'])->delete();
            foreach($costs as $line) {
                FleetOrderCost::insert([
                    'transid'=>$data['transid'],
                    'line_no'=>$line['line_no'],
                    'expense_code'=>$line['expense_code'],
                    'descriptions'=>$line['descriptions'],
                    'standar_budget'=>$line['standar_budget'],
                    'expense'=>$line['expense'],
                    'is_invoice'=>$line['is_invoice'],
                    'acuan'=>$line['acuan'],
                    'fee'=>$line['fee'],
                    'notes'=>isset($line['notes']) ? $line['notes'] :''
                ]);
            }
            FleetOrder::where('transid',$data['transid'])
            ->update([
                'cost_date'=>$data['cost_date'],
                'work_status'=>'Closed',
                'is_closed_expense'=>'1',
                'is_closed_order'=>'1',
                'budget'=>$data['budget'],
                'expense'=>$data['expense'],
                'other_bill'=>$data['fee'],
                'total'=>$oprs->net_price+floatval($data['fee'])
            ]);
            /** Save Cost to row**/
            $costdetail=FleetOrderCost::selectRaw("expense_code,expense")->where('transid',$data['transid'])->get();
            $costdtl=array();
            $costdtl['fleet_order_id']=$data['transid'];
            foreach($costdetail as $dtl){
                $field='fleet_cost'.strval($dtl->expense_code);
                $value=$dtl->expense;
                $costdtl[$field]=$value;
            }
            FleetOrderRowCost::where('fleet_order_id',$data['transid'])->delete();
            FleetOrderRowCost::insert($costdtl);
            $info=$this->build_jurnal($data['transid'],$request);
            if ($info['state']==true){
                PagesHelp::write_log($request,'Close LBO',-1,$data['transid'],'LBO '.$oprs->work_order_no);
                DB::commit();
                return response()->success('Success','Registrasi biaya operasional berhasi dibuat');
            } else {
                DB::rollback();
                return response()->error('', 501, $info['message']);
            }
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public static function build_jurnal($sysid,$request) {
        /* Jurnal Closing Biaya Kegiatan
           Unbill
             Pendapatan
         */
        $ret['state']=true;
        $ret['message']=''; 
        $data=FleetOrder::from('t_fleet_order as a')
        ->selectRaw("a.transid,a.ref_date,a.partner_id,a.pool_code,a.order_no,a.work_order_no,a.partner_id,a.total,
          b.partner_name,a.customer_no,a.police_no,a.vehicle_no,a.no_jurnal,a.trans_code,a.trans_series")
        ->join('m_partner as b','a.partner_id','=','b.partner_id')
        ->where('a.transid',$sysid)->first();
        if ($data){
            $total=floatval($data->total);

            $realdate = date_create($data->ref_date);
            $year_period = date_format($realdate, 'Y');
            $month_period = date_format($realdate, 'm');
            if ($data->no_jurnal==-1){
                $no_jurnal=Journal1::max('transid')+1;
                $series = Journal1::GenerateNumber('SPJ',$data->ref_date);
                Journal1::insert([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->work_order_no,
                  'reference2'=>$data->order_no,
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>'SPJ',
                  'trans_series'=>$series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>'3',
                  'notes'=>$data->partner_name.'-'.$data->customer_no.'-'.$data->police_no
              ]);      
            } else {
                $no_jurnal=$data->no_jurnal;
                $series=$data->trans_series;
                Accounting::rollback($no_jurnal);    
                Journal1::where('transid',$no_jurnal)
                ->update([
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->work_order_no,
                  'reference2'=>$data->order_no,
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>'SPJ',
                  'trans_series'=>$series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>'3',
                  'notes'=>$data->partner_name.'-'.$data->customer_no.'-'.$data->police_no
                ]);
            }
            /* UnBill */
            $acc=GeneralAcc::selectRaw("unbill_account,revenue_account")->where('id',1)->first();
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>1,
                'no_account'=>$acc->unbill_account,
                'line_memo'=>$data->partner_name.'-'.$data->customer_no.'-'.$data->police_no,
                'reference1'=>$data->work_order_no,
                'reference2'=>$data->order_no,
                'due_date'=>$data->ref_date,
                'debit'=>$total,
                'credit'=>0,
                'crdebit'=>$total,
                'crcredit'=>0,
            ]);
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>2,
                'no_account'=>$acc->revenue_account,
                'line_memo'=>$data->partner_name.'-'.$data->customer_no.'-'.$data->police_no,
                'reference1'=>$data->work_order_no,
                'reference2'=>$data->order_no,
                'due_date'=>$data->ref_date,
                'debit'=>0,
                'credit'=>$total,
                'crdebit'=>0,
                'crcredit'=>$total,
            ]);
            $info=Accounting::posting($no_jurnal,$request);
            if ($info['state']==true){
                FleetOrder::where('transid',$sysid)
                ->update([
                    'no_jurnal'=>$no_jurnal,
                    'trans_code'=>'SPJ',
                    'trans_series'=>$series,
                ]);
            }
            $ret['state']=$info['state'];
            $ret['message']=$info['message'];        
        } else {
            $ret['state']=false;
            $ret['message']='Data tidak ditemukan'; 
        }
        return $ret;
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
        $reason=isset($request->reason) ? $request->reason :'';
        $data=FleetOrder::find($transid);
        if ($data) {
            if (!($data->work_status=='Open')) {
                return response()->error('',501,'Planning order/Surat Muatan sudah diproses/dibatalkan');
            }
            if (FleetExpense1::where('fleet_orderid',$data->transid)
            ->where("is_closed",1)->where("is_canceled",0)->exists()) {
                return response()->error('',501,'LBO untuk surat muat tersebut sudah ada pengeluaran kasir-nya');
            }
            DB::beginTransaction();
            try {
                $data->update([
                    'work_status'=>'Cancel',
                    'cancel_date'=>Date('Y-m-d h:i:s'),
                    'cancel_note'=>$request->reason,
                    'cancel_userid'=>PagesHelp::UserID($request)
                ]);
                FleetExpense1::where('fleet_orderid',$transid)
                ->update([
                    "is_canceled"=>"1",
                    "canceled_date"=>Date('Y-m-d'),
                    'canceled_notes'=>$request->reason,
                    'canceled_by'=>PagesHelp::UserID($request)
                ]);
                CustomerOrder::where('work_order_id',$transid)
                ->update([
                    'work_order_id'=>'-1',
                    'work_order_no'=>'',
                    'work_order_date'=>null,
                    'is_transactionlink'=>'0',
                    'order_status'=>'Open'
                ]);
                Vehicles::where('vehicle_no',$data->vehicle_no)
                ->update([
                    'work_order_sysid'=>'-1',
                    'work_order_date'=>null,
                    'work_order_number'=>'',
                    'work_order_driver_id'=>'',
                    'work_order_driver_name'=>''
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
    public function print_sj(Request $request){
        $item = array();
        $sysid=$request->sysid;
        $header=FleetOrder::from('t_fleet_order as a')
        ->selectRaw("a.transid,a.ref_date,.a.order_no,a.pool_code,a.work_order_no,a.customer_no,.a.customer_no1,a.vehicle_no,a.police_no,
            a.work_order_type,a.work_type,a.origins,a.destination,a.partner_id,c.partner_name,a.customer_name,
            a.warehouse,a.employee_id,b.personal_name,IFNULL(b.phone1,'') AS phone1,IFNULL(b.phone2,'') AS phone2,
            IFNULL(b.driving_license_type,'') sim_type,b.driving_license_valid,a.customer_name,a.partner_id")
        ->leftJoin('m_personal as b','a.employee_id','=','b.employee_id')
        ->leftJoin('m_partner as c','a.partner_id','=','c.partner_id')
        ->where('a.transid',$sysid)->first();
        if ($header) {
            $profile=PagesHelp::Profile();
            $pdf = PDF::loadView('operation.surat_muatan',['header'=>$header,'profile'=>$profile])->setPaper('A4','potriat');
            return $pdf->stream();
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }

    public function print_lbo(Request $request){
        $item = array();
        $sysid=$request->sysid;
        $header=FleetExpense1::from('t_fleet_expense1 as a')
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.fleet_order_no,a.pool_code,b.order_no,
            a.other_expense,a.dp_customer,a.total,a.cashier,a.dp_method,
            b.vehicle_no,b.police_no,b.vehicle_group,b.employee_id,b.driver_name,
            b.origins,b.destination,b.customer_no,b.customer_name,c.partner_name,b.partner_id,d.user_name,a.total,
            e.driving_license_type,e.driving_license_valid")
        ->leftJoin('t_fleet_order as b','a.fleet_orderid','=','b.transid')
        ->leftJoin('m_partner as c','b.partner_id','=','c.partner_id')
        ->leftJoin('o_users as d','a.update_userid','=','d.user_id')
        ->leftJoin('m_personal as e','b.employee_id','=','e.employee_id')
        ->where('a.transid',$sysid)->first();
        if ($header) {
            $profile=PagesHelp::Profile();
            $detail=FleetExpense2::selectRaw("transid,line_no,expense_code,descriptions,expense_budget")
            ->where("transid",$header->transid)
            ->where("expense_budget","<>",0)
            ->get();
            $pdf = PDF::loadView('operation.lbo',['header'=>$header,'detail'=>$detail,'profile'=>$profile])->setPaper('A4','potriat');
            return $pdf->stream();
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }
}
