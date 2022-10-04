<?php

namespace App\Http\Controllers\Finance;

use App\Models\Operation\FleetOrder;
use App\Models\Operation\FleetExpense1;
use App\Models\Operation\FleetExpense2;
use App\Models\Finance\CashBankTransaction;
use App\Models\Finance\CashBank1;
use App\Models\Finance\CashBank2;
use App\Models\Finance\CashBankUJO1;
use App\Models\Finance\CashBankUJO2;
use App\Models\Master\CashBank;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;
use Accounting;
use AutoJurnal;
use PDF;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CashBankController extends Controller
{
    public function show(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1:'1899-12-31';
        $date2 = isset($request->date2) ? $request->date2:'1899-12-31';
        $cash_id = isset($request->cash_id) ? $request->cash_id:'ALL';

        $data=CashBankTransaction::from("t_cashbank_transaction as a")
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.no_jurnal,CONCAT(a.trans_code,'-',a.trans_series) as voucher,
            a.descriptions,IF(a.amount>0,a.amount,0) as debet,IF(a.amount<0,ABS(a.amount),0) as credit,a.linkdoc_number,
            a.linkdocument_id,a.is_void,a.is_posted,a.cashbank_source,a.cashbank_sname,a.pool_code,a.document_type")
        ->where("a.ref_date",">=",$date1)
        ->where("a.ref_date","<=",$date2);
        if (!($cash_id=='ALL')) {
            $data=$data->where("a.cashbank_source",$cash_id);
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.linkdoc_number', 'like', $filter);
                $q->orwhere('a.cashbank_sname', 'like', $filter);
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

    public function openLBO(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $pool_code = isset($request->pool_code) ? $request->pool_code:'';

        $data=FleetExpense1::from("t_fleet_expense1 as a")
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.fleet_orderid,a.fleet_order_no,a.pool_code,
        a.standart,a.other_expense,a.total,a.cashier,a.cash_amount,b.driver_name,b.customer_no,b.vehicle_no,b.police_no,a.is_authorize,
        a.authorize_date,a.authorize_userid,a.other_expense,a.dp_customer,a.total,a.cashier,a.cash_amount")
        ->leftjoin("t_fleet_order as b","a.fleet_orderid","=","b.transid") 
        ->where("a.pool_code",$pool_code)   
        ->where("a.is_closed",'0')   
        ->whereRaw("(a.cashier-a.cash_amount)>0");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('b.driver_name', 'like', $filter);
                $q->orwhere('b.vehicle_no', 'like', $filter);
                $q->orwhere('b.police_no', 'like', $filter);
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

    public function GetLBO(Request $request)
    {
        $sysid = isset($request->sysid) ? $request->sysid : '-1';
        $data['cost']=FleetExpense1::from("t_fleet_expense1 as a")
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.fleet_orderid,a.fleet_order_no,a.pool_code,a.project_id,
        a.cashier,a.cash_amount,b.driver_name,b.customer_no,b.vehicle_no,b.police_no,a.is_authorize,
        a.authorize_date,a.authorize_userid,a.other_expense,a.dp_customer,a.total,a.cashier,a.cash_amount,a.standart,a.dp_method")
        ->leftjoin("t_fleet_order as b","a.fleet_orderid","=","b.transid") 
        ->where("a.transid",$sysid)->first();
        $data['costs']=FleetExpense2::selectRaw("line_no,expense_code,descriptions,expense_budget,expense,
        IFNULL(expense_budget,0)-IFNULL(expense,0) as cashier,account_no")
        ->where("transid",$sysid)->get();
        return response()->success('Success', $data);
    }

    public function Cashier_LBO(Request $request){
        $transid=isset($request->sysid) ? $request->sysid : '-1';
        $data['cost']=CashBankUJO1::from("t_fleet_expense_cashier1 as a")
        ->selectRaw("a.transid,a.ref_date,a.pool_code,a.expense_transid,a.expense_no,a.cash_id,a.driver_name,
        a.no_jurnal,a.trans_code,a.trans_series,a.descriptions,a.expense,a.adm_fee,a.total,a.project_id,
        b.standart,b.dp_method,b.dp_customer,b.cashier")
        ->leftjoin("t_fleet_expense1 as b","a.expense_transid","=","b.transid")
        ->where("a.transid",$transid)->first();
        if (!($data['cost'])) {
            $data['cost']=array();
        }
        $data['costs']=CashBankUJO2::selectRaw("transid,line_no,expense_code,descriptions,budget,expense_out,
            expense,line_note,account_no")->where("transid",$transid)->get();
        return response()->success('Success',$data);
    }

    public function get_cashier_ujo(Request $request){
        $transid=isset($request->sysid) ? $request->sysid : '-1';
        $data=CashBankUJO1::selectRaw("transid,ref_date,pool_code,expense_transid,expense_no,cash_id,driver_name,
        no_jurnal,trans_code,trans_series,descriptions,expense,adm_fee,total,project_id,
        CONCAT(trans_code,'-',trans_series) as voucher,is_canceled,canceled_by,canceled_date")->where("expense_transid",$transid)->get();
        return response()->success('Success',$data);
    }

    public function post_LBO(Request $request){
        $info  = $request->json()->all();
        $cost  = $info['header'];
        $costs = $info['cost'];
        $validator=Validator::make($cost,
        [
            'ref_date'=>'bail|required',
            'expense_no'=>'bail|required',
            'cash_id'=>'bail|required',
            'trans_code'=>'bail|required',
        ],[
            'ref_date.required'=>'Tanggal pengeluaran kas/bank harus diisi',
            'expense_no.required'=>'Nomor LBO harus diisi',
            'cash_id.required'=>'Kas/Bank harus diisi',
            'trans_code.required'=>'Voucher transaksi harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        foreach($costs as $line){
            if ($line['expense']> ($line['budget']+$line['expense_out'])) {
                return response()->error('',501,'Pengeluaran tidak boleh lebih besar dari pengajuan');

            } elseif ($line['expense']<0) {
                return response()->error('',501,'Pengeluaran tidak boleh lebih kecil dari NOL');
            }
        }
        $expense=FleetExpense1::find($cost['expense_transid']);
        if ($expense){
            if ($expense->is_authoize=='0') {
                return response()->error('',501,'Pengajuan LBO tersebut belum diotorisasi');
            } elseif ($expense->is_canceled=='1') {
                return response()->error('',501,'Pengajuan LBO tersebut dibatalkan');
            } else if (($expense->dp_valid=='0') && ($expense->dp_method=='TRANSFER')) {
                return response()->error('',501,'Pengajuan LBO tersebut ada DP UJO ditransfer yang belum di validasi');
            }
            $oprs=FleetOrder::find($expense->fleet_orderid);
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
        } else {
            return response()->error('',501,'Pengajuan biaya operasional (LBO) tidak ditemukan');
        }
        DB::beginTransaction();
        try {
            $UJO=CashBankUJO1::find($cost['transid']);
            $CashBank=CashBank::find($cost['cash_id']);
            if (!($UJO)) {
                $cost['trans_series'] = Accounting::GenerateNumber($cost['trans_code'],$cost['ref_date']);
                $sysid=CashBankUJO1::insertGetId([
                    'ref_date'=>$cost['ref_date'],
                    'expense_transid'=>$cost['expense_transid'],
                    'expense_no'=>$cost['expense_no'],
                    'pool_code'=>$cost['pool_code'],
                    'cash_id'=>$cost['cash_id'],
                    'trans_code'=>$cost['trans_code'],
                    'trans_series'=>$cost['trans_series'],
                    'expense'=>$cost['expense'],
                    'adm_fee'=>$cost['adm_fee'],
                    'total'=>$cost['total'],
                    'employee_id'=>$oprs->employee_id,
                    'driver_name'=>$oprs->driver_name,
                    'descriptions'=>$oprs->work_order_no.' / '.$oprs->origins.' - '.$oprs->destination.' - '.$oprs->vehicle_no.' - '.$oprs->vehicle_no.' - '.$oprs->driver_name,
                    'no_jurnal'=>'-1',
                    'is_canceled'=>'0',
                    'no_jurnal_void'=>'-1',
                    'project_id'=>$oprs->project_id,
                    'account_no'=>$CashBank->account_number,
                    'account_name'=>$CashBank->account_name,
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            } else {
                if ($UJO->is_canceled=='1') {
                    DB::rollback();    
                    return response()->error('',501,'LBO ini sudah dibatalkan,tidak bisa diubah');
                }
                $sysid=$UJO->transid;
                CashBankUJO1::where('transid',$sysid)
                ->update([
                    'ref_date'=>$cost['ref_date'],
                    'expense_transid'=>$cost['expense_transid'],
                    'expense_no'=>$cost['expense_no'],
                    'pool_code'=>$cost['pool_code'],
                    'cash_id'=>$cost['cash_id'],
                    'trans_code'=>$cost['trans_code'],
                    'trans_series'=>$cost['trans_series'],
                    'expense'=>$cost['expense'],
                    'adm_fee'=>$cost['adm_fee'],
                    'total'=>$cost['total'],
                    'employee_id'=>$oprs->employee_id,
                    'driver_name'=>$oprs->driver_name,
                    'descriptions'=>$oprs->work_order_no.' / '.$oprs->origins.' - '.$oprs->destination.' - '.$oprs->vehicle_no.' - '.$oprs->vehicle_no.' - '.$oprs->driver_name,
                    'project_id'=>$oprs->project_id,
                    'account_no'=>$CashBank->account_number,
                    'account_name'=>$CashBank->account_name,
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
                $olds=CashBankUJO1::from('t_fleet_expense_cashier1 as a')
                ->selectRaw("a.transid,a.expense_transid,b.expense_code,b.expense")
                ->join("t_fleet_expense_cashier2 as b","a.transid","=","b.transid")
                ->where('a.transid',$sysid)
                ->where('a.expense',"<>","0")->get();
                foreach($olds as $old) {
                    DB::update("UPDATE t_fleet_expense2 SET expense=IFNULL(expense,0)-? WHERE transid=? AND expense_code=?",
                    [$old->expense,$old->expense_transid,$old->expense_code]);
                }
                CashBankUJO2::where('transid',$sysid)->delete();
            }
            foreach($costs as $line) {
                CashBankUJO2::insert([
                    'transid'=>$sysid,
                    'line_no'=>$line['line_no'],
                    'expense_code'=>$line['expense_code'],
                    'descriptions'=>$line['descriptions'],
                    'account_no'=>$line['account_no'],
                    'budget'=>$line['budget'],
                    'expense_out'=>$line['expense_out'],
                    'expense'=>$line['expense'],
                    'line_note'=>isset($line['line_note']) ? $line['line_note'] :''
                ]);
                if (floatval($line['expense'])>0) {
                    DB::update("UPDATE t_fleet_expense2 SET expense=IFNULL(expense,0)+? WHERE transid=? AND expense_code=?",
                    [$line['expense'],$cost['expense_transid'],$line['expense_code']]);
                }
            }
            DB::update("UPDATE t_fleet_expense1 a INNER JOIN (SELECT a.expense_transid,SUM(b.expense) as expense FROM t_fleet_expense_cashier1 a
               INNER JOIN t_fleet_expense_cashier2 as b ON a.transid=b.transid
               WHERE a.expense_transid=? AND a.is_canceled=0
               GROUP BY a.expense_transid) as b ON a.transid=b.expense_transid
               SET a.cash_amount=b.expense,a.is_closed=IF(IFNULL(a.cashier,0)>IFNULL(b.expense,0),0,1)
               WHERE a.transid=?",[$cost['expense_transid'],$cost['expense_transid']]);

            if (FleetExpense1::where('transid',$cost['expense_transid'])
                ->whereRaw("IFNULL(cashier,0)-IFNULL(cash_amount,0)<0")->exists()){
                return response()->error('', 501, 'Pengeluaran Kasir lebih besar dari UJO');
            }   
            if (FleetExpense2::where('transid',$cost['expense_transid'])
                ->whereRaw("IFNULL(expense_budget,0)-IFNULL(expense,0)<0")->exists()){
                return response()->error('', 501, 'Alokasi biaya pengeluaran Kasir lebih besar dari UJO (Detail)');
            }   

            $info=AutoJurnal::jurnal_ujo($sysid,$request);   
            if ($info['state']==true){
                FLeetExpense1::where('transid',$cost['expense_transid'])
                ->update([
                    'no_jurnal'=>$info['no_jurnal'],
                    'trans_code'=>$cost['trans_code'],
                    'trans_series'=>$cost['trans_series'],
                    'cash_id'=>$cost['cash_id'],
                    'account_no'=>$CashBank->account_number,
                    'account_name'=>$CashBank->account_name,
                    'cash_userid'=>PagesHelp::UserID($request),
                    'descriptions'=>$oprs->work_order_no.' / '.$oprs->origins.' - '.$oprs->destination.' - '.$oprs->vehicle_no.' - '.$oprs->vehicle_no.' - '.$oprs->driver_name,
                ]);
                CashBankTransaction::Generate($sysid,'UJO');   
                PagesHelp::write_log($request,'UJO',-1,$sysid,'LBO '.$cost['expense_no']);
                DB::commit();
                $respon['sysid']=$sysid;
                $respon['message']='Pengeluaran biaya UJO berhasil';
                return response()->success('Success',$respon);
            } else {
                DB::rollback();
                return response()->error('', 501, $info['message']);
            }
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function print_lbocashier(Request $request){
        $item = array();
        $sysid=$request->sysid;
        $header=CashBankUJO1::from('t_fleet_expense_cashier1 as a')
        ->selectRaw("a.transid,CONCAT(a.trans_code,'-',a.trans_series) as voucher,a.ref_date,
                a.expense_no,a.pool_code,a.expense,a.adm_fee,a.total,d.partner_id,d.customer_name,
                e.partner_name,d.customer_no,d.driver_name,d.vehicle_no,d.police_no,d.vehicle_group,
                d.origins,d.destination,d.warehouse,d.work_order_no,d.work_order_type,d.work_type,
                f.user_name,a.update_timestamp,g.no_account,h.account_name")
        ->leftJoin('t_fleet_expense1 as c','a.expense_transid','=','c.transid')
        ->leftJoin('t_fleet_order as d','c.fleet_orderid','=','d.transid')
        ->leftJoin('m_partner as e','d.partner_id','=','e.partner_id')
        ->leftJoin('o_users as f','a.update_userid','=','f.user_id')
        ->leftJoin('m_cash_operation as g','a.cash_id','=','g.cash_id')
        ->leftJoin('m_account as h','g.no_account','=','h.account_no')
        ->where('a.transid',$sysid)->first();
        if ($header) {
            $profile=PagesHelp::Profile();
            $detail=CashBankUJO2::selectRaw("transid,line_no,expense_code,descriptions,expense")
            ->where("transid",$header->transid)
            ->where("expense","<>",0)
            ->get();
            $pdf = PDF::loadView('finance.lbo-cashier',['header'=>$header,'detail'=>$detail,'profile'=>$profile])->setPaper('A4','potriat');
            return $pdf->stream();
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }

    public function print(Request $request){
        $item = array();
        $sysid=$request->sysid;
        $document_type=$request->document_type;
        $header=CashBankTransaction::from('t_cashbank_transaction as a')
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.cashbank_sname,a.cashbank_dname,
                     amount,a.document_type,a.pool_code,a.project_id,
                     a.update_userid,IFNULL(g.user_name,a.update_userid) as user_name,a.update_timestamp,
                     a.linkdocument_id,a.linkdoc_number")
        ->leftjoin('o_users as g','a.update_userid','=','g.user_id')
        ->where('a.linkdocument_id',$sysid)
        ->where('a.document_type',$document_type)
        ->first();
        if ($header) {
            $profile=PagesHelp::Profile();
            if ($header->amount>0){
                $type='IN';
            } else {
                $type='OUT';
            }
            $detail=CashBankTransaction::selectRaw("descriptions,ABS(amount) as amount")
            ->where('linkdocument_id',$sysid)
            ->where('document_type',$document_type)
            ->get();
            if ($document_type=='UJO') {
                $order=CashBankUJO1::from("t_fleet_expense_cashier1 as a")
                ->selectRaw("a.expense_no,c.order_no,c.work_order_no,c.customer_no,c.driver_name,c.partner_id,IFNULL(d.partner_name,'') AS partner_name")
                ->join("t_fleet_expense1 as b","a.expense_transid","=","b.transid")
                ->join("t_fleet_order as c","b.fleet_orderid","=","c.transid")
                ->join("m_partner as d","c.partner_id","=","d.partner_id")
                ->where('a.transid',$sysid)
                ->first();
                $header->order=$order;
            }
            $pdf = PDF::loadView('finance.cashier',['header'=>$header,'detail'=>$detail,'profile'=>$profile,'type'=>$type])->setPaper('1/2A4','potriat');
            return $pdf->stream();
            //return View('finance.cashier',['header'=>$header,'detail'=>$detail,'profile'=>$profile,'type'=>$type]);
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }

    public function print2(Request $request){
        $item = array();
        $sysid=$request->sysid;
        $document_type=$request->document_type;
        $header=CashBankTransaction::from('t_cashbank_transaction as a')
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.cashbank_sname,a.cashbank_dname,
                     amount,a.document_type,a.pool_code,a.project_id,a.descriptions,
                     a.update_userid,IFNULL(g.user_name,a.update_userid) as user_name,a.update_timestamp,
                     a.linkdocument_id,a.linkdoc_number")
        ->leftjoin('o_users as g','a.update_userid','=','g.user_id')
        ->where('a.transid',$sysid)
        ->first();
        if ($header) {
            $profile=PagesHelp::Profile();
            if ($header->amount>0){
                $type='IN';
            } else {
                $type='OUT';
            }
            $pdf = PDF::loadView('finance.cashier2',['header'=>$header,'profile'=>$profile,'type'=>$type])->setPaper('A4','potriat');
            return $pdf->stream();
        } else {
            return response()->error('',501,'Data Tidak ditemukan');
        }
    }

    public function mutation(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $date1 = isset($request->date1) ? $request->date1:'1899-12-31';
        $date2 = isset($request->date2) ? $request->date2:'1899-12-31';
        $cash_id = isset($request->cash_id) ? $request->cash_id:'ALL';
        $is_void = isset($request->is_void) ? $request->is_void:'1';

        $data=CashBankTransaction::from("t_cashbank_transaction as a")
        ->selectRaw("a.transid,a.doc_number,a.ref_date,a.no_jurnal,CONCAT(a.trans_code,'-',a.trans_series) as voucher,
            a.descriptions,IF(a.amount>0,a.amount,0) as debet,IF(a.amount<0,ABS(a.amount),0) as credit,a.linkdoc_number,
            a.linkdocument_id,a.is_void,a.is_posted,a.cashbank_source,a.cashbank_sname,a.pool_code,a.document_type,
            a.update_timestamp,a.update_userid,a.void_userid,a.void_timestamp")
        ->where("a.ref_date",">=",$date1)
        ->where("a.ref_date","<=",$date2)
        ->where("a.cashbank_source",$cash_id);
        if (!($is_void=='0')) {
            $data=$data->where("a.is_void",'0');
        }
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.linkdoc_number', 'like', $filter);
                $q->orwhere('a.cashbank_sname', 'like', $filter);
                $q->orwhere('a.descriptions', 'like', $filter);
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
    public function state_mutation(Request $request) {
        $cash_id= $request->cash_id;
        $date1  = $request->date1;
        $date2  = $request->date2;
        $start_year=date_format(date_create($date1),'Y').'-01-01';

        $year=date_format(date_create($date1),'Y');
        $bigbal=DB::table('t_cashbank_yearly')->selectRaw("begining_balance")
        ->where('cash_id',$cash_id)
        ->where('year_period',$year)->first();
        $data['begining']=isset($bigbal->begining_balance) ? floatval($bigbal->begining_balance) :0;

        $begining=CashBankTransaction::selectRaw("SUM(amount) as begining")
        ->where("cashbank_source",$cash_id)
        ->where("ref_date",">=",$start_year)
        ->where("ref_date","<",$date1)
        ->where("is_void",'0')
        ->first();
        $data['begining']=$data['begining'] + (isset($begining->begining) ? floatval($begining->begining) :0);

        $mutasi=CashBankTransaction::selectRaw("SUM(IF(amount>0,amount,0) )AS debit,SUM(IF(amount<0,ABS(amount),0)) AS credit")
        ->where("cashbank_source",$cash_id)
        ->where("ref_date",">=",$date1)
        ->where("ref_date","<=",$date2)
        ->where("is_void",'0')
        ->first();
        $data['debit']=isset($mutasi->debit) ? floatval($mutasi->debit) :0;
        $data['credit']=isset($mutasi->credit) ? floatval($mutasi->credit) :0;
        $data['last']=$data['begining']+($data['debit']-$data['credit']);
        return response()->success('Success', $data);
    }
    public function get(Request $request){
       $data=CashBankTransaction::
       selectRaw("transid,doc_number,ref_date,cashbank_source,cashbank_destination,descriptions,
       ABS(IFNULL(amount,0)) as amount,no_jurnal,trans_code,trans_series,linkdocument_id,linkdoc_number,
       document_type,pool_code")
       ->where("transid",isset($request->sysid) ? $request->sysid:'-1')
       ->first();
        return response()->success('Success', $data);
    }

    public function get2(Request $request){
       $data['header']=CashBank1::selectRaw("transid,ref_date,due_date,reference1,reference2,cash_id,
                        descriptions,is_ge,cheque_no,amount,trans_code,trans_series,no_jurnal")
       ->where("transid",isset($request->sysid) ? $request->sysid:'-1')
       ->first();
       $data['detail']=CashBank2::
       selectRaw("transid,line_no,line_memo,amount,enum_type,enum_partner,IFNULL(partner_id,'') as partner_id")
       ->where("transid",isset($request->sysid) ? $request->sysid:'-1')
       ->get();
        return response()->success('Success', $data);
    }

    public function post_droping(Request $request){
        $json  = $request->json()->all();
        $data  = $json['data'];
        $opr   = isset($json['operation']) ? $json['operation'] :'inserted';
        $document_type=config('constants.cashbank.DROPING_UJO');

        $validator=Validator::make($data,
        [
            'ref_date'=>'bail|required',
            'cashbank_source'=>'bail|required',
            'cashbank_destination'=>'bail|required',
            'trans_code'=>'bail|required',
            'descriptions'=>'bail|required',
            'amount'=>'bail|required|min:1',
        ],[
            'ref_date.required'=>'Tanggal droping harus diisi',
            'cashbank_source.required'=>'Bank sumber/asal harus diisi',
            'cashbank_destination.required'=>'Bank tujuan harus diisi',
            'trans_code.required'=>'Voucher transaksi harus diisi',
            'descriptions.required'=>'Keterangan harus diisi',
            'amount.required'=>'Nilai droping harus diisi',
            'amount.min'=>'Nilai transfer tidak boleh lebih kecil dari NOL',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        if ($opr=='updated') {
            $transid=$header['transid'];
            $trx=CashBankTransaction::where('transid',$transid)
                ->where('document_type',$document_type)->first();
            if ($trx){
                if ($trx->is_void=='1'){
                    return response()->error('',501,'Data transaksi sudah divoid');
                } else if ($trx->is_received=='1'){
                    return response()->error('',501,'Data transaksi DROPING KAS/BANK ini sudah diterima/diproses');
                }
            } else {
                return response()->error('',501,'Data transaksi tidak ditemukan');
            }
        }
        $bank=CashBank::selectRaw("descriptions")->where('cash_id',$data['cashbank_source'])->first();
        $data['cashbank_sname']=isset($bank->descriptions) ? $bank->descriptions :'';
        $bank=CashBank::selectRaw("descriptions")->where('cash_id',$data['cashbank_destination'])->first();
        $data['cashbank_dname']=isset($bank->descriptions) ? $bank->descriptions :'';

        DB::beginTransaction();
        try {
            if ($opr=='inserted') {
                $transid=CashBankTransaction::max("transid")+1;
                $trans_series = Accounting::GenerateNumber($data['trans_code'],$data['ref_date']);
                $data['trans_series']=$trans_series;
                CashBankTransaction::insert([
                    'transid'=>$transid,
                    'doc_number'=>$data['trans_code'].'-'.$data['trans_series'],
                    'ref_date'=>$data['ref_date'],
                    'cashbank_source'=>$data['cashbank_source'],
                    'cashbank_sname'=>$data['cashbank_sname'],
                    'cashbank_destination'=>$data['cashbank_destination'],
                    'cashbank_dname'=>$data['cashbank_dname'],
                    'descriptions'=>$data['descriptions'],
                    'amount'=> - abs($data['amount']),
                    'no_jurnal'=>-1,
                    'is_received'=>'0',
                    'trans_code'=>$data['trans_code'],
                    'trans_series'=>$data['trans_series'],
                    'is_posted'=>'0',
                    'linkdocument_id'=>-1,
                    'linkdoc_number'=>$data['trans_code'].'-'.$data['trans_series'],
                    'document_type'=>$document_type,
                    'pool_code'=>'',
                    'project_id'=>'',
                    'is_void'=>'0',
                    'update_userid'=>Pageshelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]) ;
            } else {
                $transid=$data["transid"];
                CashBankTransaction::where('transid',$transid)
                ->where('document_type',$document_type)
                ->update([
                    'transid'=>$transid,
                    'doc_number'=>$data['trans_code'].'-'.$data['trans_series'],
                    'ref_date'=>$data['ref_date'],
                    'cashbank_source'=>$data['cashbank_source'],
                    'cashbank_sname'=>$data['cashbank_sname'],
                    'cashbank_destination'=>$data['cashbank_destination'],
                    'cashbank_dname'=>$data['cashbank_dname'],
                    'descriptions'=>$data['descriptions'],
                    'amount'=> - abs($data['amount']),
                    'is_posted'=>'0',
                    'linkdocument_id'=>-1,
                    'linkdoc_number'=>$data['trans_code'].'-'.$data['trans_series'],
                    'document_type'=>$document_type,
                    'pool_code'=>'',
                    'project_id'=>'LAIN',
                    'update_userid'=>Pageshelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]) ;
            }
            $info=AutoJurnal::jurnal_droping($transid,$request);
            if ($info['state']==true){
                PagesHelp::write_log($request,$document_type,-1,$transid,'Droping kas/bank '.number_format($data['amount'],0,',','.'));
                DB::commit();
                $respon['sysid']=$transid;
                $respon['message']='Droping Kas/Bank berhasil';
                return response()->success('Success',$respon);
            } else {
                DB::rollback();
                return response()->error('', 501, $info['message']);
            }
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function open_droping(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $userid=PagesHelp::UserID($request);
        $document_type=config('constants.cashbank.DROPING_UJO');
        $data=CashBankTransaction::from("t_cashbank_transaction as a")
            ->selectRaw("a.transid,a.doc_number,a.ref_date,a.no_jurnal,CONCAT(a.trans_code,'-',a.trans_series) as voucher,
                a.descriptions,ABS(a.amount) as amount,a.linkdoc_number,
                a.linkdocument_id,a.is_void,a.is_posted,a.cashbank_source,a.cashbank_sname,
                a.cashbank_destination,a.cashbank_dname,a.pool_code,a.document_type")
            ->join('o_user_cashbank as b',function($join) use($userid) {
                $join->on("a.cashbank_destination","=","b.cash_id");
                $join->on("b.user_id","=",DB::raw("'$userid'"));
            })
            ->where("a.is_received","0")
            ->where("a.document_type",$document_type)
            ->where("a.is_void",'0')
            ->where("b.is_allow",'1');
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.doc_number', 'like', $filter);
                $q->orwhere('a.linkdoc_number', 'like', $filter);
                $q->orwhere('a.cashbank_sname', 'like', $filter);
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
    public function post_receive_droping(Request $request){
        $json  = $request->json()->all();
        $data  = $json['data'];
        $opr   = isset($json['operation']) ? $json['operation'] :'inserted';
        $document_type=config('constants.cashbank.RECEIVE_UJO');

        $validator=Validator::make($data,
        [
            'ref_date'=>'bail|required',
            'pool_code'=>'bail|required',
            'cashbank_source'=>'bail|required',
            'cashbank_destination'=>'bail|required',
            'trans_code'=>'bail|required',
            'descriptions'=>'bail|required',
            'amount'=>'bail|required|min:1',
        ],[
            'ref_date.required'=>'Tanggal droping harus diisi',
            'pool_code.required'=>'Pool harus diisi',
            'cashbank_source.required'=>'Bank sumber/asal harus diisi',
            'cashbank_destination.required'=>'Bank tujuan harus diisi',
            'trans_code.required'=>'Voucher transaksi harus diisi',
            'descriptions.required'=>'Keterangan harus diisi',
            'amount.required'=>'Nilai droping harus diisi',
            'amount.min'=>'Nilai transfer tidak boleh lebih kecil dari NOL',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        if ($opr=='updated') {
            $transid=$header['transid'];
            $trx=CashBankTransaction::where('transid',$transid)
                ->where('document_type',$document_type)->first();
            if ($trx){
                if ($trx->is_void=='1'){
                    return response()->error('',501,'Data transaksi sudah divoid');
                } else if ($trx->is_received=='1'){
                    return response()->error('',501,'Data transaksi DROPING KAS/BANK ini sudah diterima/diproses');
                }
            } else {
                return response()->error('',501,'Data transaksi tidak ditemukan');
            }
        }
        $bank=CashBank::selectRaw("descriptions")->where('cash_id',$data['cashbank_source'])->first();
        $data['cashbank_sname']=isset($bank->descriptions) ? $bank->descriptions :'';
        $bank=CashBank::selectRaw("descriptions")->where('cash_id',$data['cashbank_destination'])->first();
        $data['cashbank_dname']=isset($bank->descriptions) ? $bank->descriptions :'';

        DB::beginTransaction();
        try {
            if ($opr=='inserted') {
                $transid=CashBankTransaction::max("transid")+1;
                $trans_series = Accounting::GenerateNumber($data['trans_code'],$data['ref_date']);
                $data['trans_series']=$trans_series;
                CashBankTransaction::insert([
                    'transid'=>$transid,
                    'doc_number'=>$data['trans_code'].'-'.$data['trans_series'],
                    'ref_date'=>$data['ref_date'],
                    'cashbank_source'=>$data['cashbank_source'],
                    'cashbank_sname'=>$data['cashbank_sname'],
                    'cashbank_destination'=>$data['cashbank_destination'],
                    'cashbank_dname'=>$data['cashbank_dname'],
                    'descriptions'=>$data['descriptions'],
                    'amount'=> $data['amount'],
                    'no_jurnal'=>-1,
                    'is_received'=>'0',
                    'trans_code'=>$data['trans_code'],
                    'trans_series'=>$data['trans_series'],
                    'is_posted'=>'0',
                    'linkdocument_id'=>$data['linkdocument_id'],
                    'linkdoc_number'=>$data['linkdoc_number'],
                    'document_type'=>$document_type,
                    'pool_code'=>$data['pool_code'],
                    'project_id'=>'',
                    'is_void'=>'0',
                    'update_userid'=>Pageshelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]) ;
            } else {
                $transid=$data["transid"];
                CashBankTransaction::where('transid',$transid)
                ->where('document_type',$document_type)
                ->update([
                    'transid'=>$transid,
                    'doc_number'=>$data['trans_code'].'-'.$data['trans_series'],
                    'ref_date'=>$data['ref_date'],
                    'cashbank_source'=>$data['cashbank_source'],
                    'cashbank_sname'=>$data['cashbank_sname'],
                    'cashbank_destination'=>$data['cashbank_destination'],
                    'cashbank_dname'=>$data['cashbank_dname'],
                    'descriptions'=>$data['descriptions'],
                    'amount'=> $data['amount'],
                    'is_posted'=>'0',
                    'linkdocument_id'=>$data['linkdocument_id'],
                    'linkdoc_number'=>$data['linkdoc_number'],
                    'document_type'=>$document_type,
                    'pool_code'=>$data['pool_code'],
                    'project_id'=>'',
                    'update_userid'=>Pageshelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]) ;
            }
            $info=AutoJurnal::jurnal_receive_droping($transid,$request);
            if ($info['state']==true){
                PagesHelp::write_log($request,$document_type,-1,$transid,'Penerimaan droping kas/bank '.number_format($data['amount'],0,',','.'));
                DB::commit();
                $respon['sysid']=$transid;
                $respon['message']='Penerimaan droping Kas/Bank berhasil';
                return response()->success('Success',$respon);
            } else {
                DB::rollback();
                return response()->error('', 501, $info['message']);
            }
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function post_cashbankout(Request $request){
        $info  = $request->json()->all();
        $header  = $info['header'];
        $details = $info['detail'];
        $opr    = isset($info['operation']) ? $info['operation'] :'inserted';
        $validator=Validator::make($header,
        [
            'ref_date'=>'bail|required',
            'cash_id'=>'bail|required',
            'trans_code'=>'bail|required',
            'due_date'=>'bail|required',
        ],[
            'ref_date.required'=>'Tanggal pengeluaran kas/bank harus diisi',
            'cash_id.required'=>'Kas/Bank harus diisi',
            'trans_code.required'=>'Voucher transaksi harus diisi',
            'ref_date.required'=>'Tanggal jatuh tempo harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        if ($opr=='updqated'){
            $data=CashBank1::find($cost['transid']);
            if ($expense){
                if ($expense->is_posted=='0') {
                    return response()->error('',501,'Transaksi kas/bank sudah diposting');
                } elseif ($expense->is_void=='1') {
                    return response()->error('',501,'Transaksi kas/bank sudah divoid/dibatalkan');
                } else {
                    return response()->error('',501,'Kegiatan operasi tidak ditemukan');
                }
            } else {
                return response()->error('',501,'Pengajuan biaya operasional (LBO) tidak ditemukan');
            }
        }
        DB::beginTransaction();
        try {
            $CashBank=CashBank1::find($header['transid']);
            if (!($CashBank)) {
                $header['trans_series'] = Accounting::GenerateNumber($header['trans_code'],$header['ref_date']);
                $transid=CashBank1::max("transid")+1;
                CashBank1::insert([
                    'transid'=>$transid,
                    'ref_date'=>$header['ref_date'],
                    'is_ge'=>$header['is_ge'],
                    'ref_date'=>$header['ref_date'],
                    'due_date'=>$header['due_date'],
                    'cheque_no'=>$header['cheque_no'],
                    'descriptions'=>$header['descriptions'],
                    'trans_code'=>$header['trans_code'],
                    'trans_series'=>$header['trans_series'],
                    'cash_id'=>$header['cash_id'],
                    'amount'=>$header['amount'],
                    'no_account'=>'',
                    'no_jurnal'=>'-1',
                    'is_posted'=>'0',
                    'enum_inout'=>'OUT',
                    'db_version'=>'-',
                    'app_version'=>'-',
                    'is_void'=>'0',
                    'no_jurnal_void'=>'-1',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s'),
                    'update_location'=>$request->ip()
                ]);
            } else {
                $transid=$header['transid'];
                CashBank1::where('transid',$transid)
                ->update([
                    'transid'=>$transid,
                    'ref_date'=>$header['ref_date'],
                    'is_ge'=>$header['is_ge'],
                    'ref_date'=>$header['ref_date'],
                    'due_date'=>$header['due_date'],
                    'cheque_no'=>$header['cheque_no'],
                    'descriptions'=>$header['descriptions'],
                    'trans_code'=>$header['trans_code'],
                    'trans_series'=>$header['trans_series'],
                    'cash_id'=>$header['cash_id'],
                    'amount'=>$header['amount'],
                    'no_account'=>'',
                    'no_jurnal'=>'-1',
                    'is_posted'=>'0',
                    'enum_inout'=>'OUT',
                    'db_version'=>'-',
                    'app_version'=>'-',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s'),
                    'update_location'=>$request->ip()
                ]);
                CashBank2::where('transid',$transid)->delete();
            }
            foreach($details as $line) {
                CashBank2::insert([
                    'transid'=>$transid,
                    'line_no'=>$line['line_no'],
                    'line_memo'=>$line['line_memo'],
                    'amount'=>$line['amount'],
                    'partner_id'=>$line['partner_id'],
                    'no_account'=>'',
                    'enum_type'=>$line['enum_type'],
                    'enum_partner'=>'3',
                    'control_account'=>'',
                    'description'=>''
                ]);
            }
            $CashBank=CashBank::find($header['cash_id']);
            $document_type=config('constants.cashbank.BANK_OUT');
            CashBankTransaction::Generate($transid,$document_type);   
            PagesHelp::write_log($request,'OUT',-1,$transid,'OUT '.$header['trans_code'].'-'.$header['trans_series']);
            DB::commit();
            $respon['sysid']=$transid;
            $respon['message']='Pengeluaran Kas/bank berhasil';
            return response()->success('Success',$respon);
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }


    public function post_cashbankin(Request $request){
        $info  = $request->json()->all();
        $header  = $info['header'];
        $details = $info['detail'];
        $opr    = isset($info['operation']) ? $info['operation'] :'inserted';
        $validator=Validator::make($header,
        [
            'ref_date'=>'bail|required',
            'cash_id'=>'bail|required',
            'trans_code'=>'bail|required',
            'due_date'=>'bail|required',
        ],[
            'ref_date.required'=>'Tanggal pengeluaran kas/bank harus diisi',
            'cash_id.required'=>'Kas/Bank harus diisi',
            'trans_code.required'=>'Voucher transaksi harus diisi',
            'ref_date.required'=>'Tanggal jatuh tempo harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        if ($opr=='updqated'){
            $data=CashBank1::find($cost['transid']);
            if ($expense){
                if ($expense->is_posted=='0') {
                    return response()->error('',501,'Transaksi kas/bank sudah diposting');
                } elseif ($expense->is_void=='1') {
                    return response()->error('',501,'Transaksi kas/bank sudah divoid/dibatalkan');
                } else {
                    return response()->error('',501,'Kegiatan operasi tidak ditemukan');
                }
            } else {
                return response()->error('',501,'Dokumen tidak ditemukan');
            }
        }
        DB::beginTransaction();
        try {
            $CashBank=CashBank1::find($header['transid']);
            if (!($CashBank)) {
                $header['trans_series'] = Accounting::GenerateNumber($header['trans_code'],$header['ref_date']);
                $transid=CashBank1::max("transid")+1;
                CashBank1::insert([
                    'transid'=>$transid,
                    'ref_date'=>$header['ref_date'],
                    'is_ge'=>$header['is_ge'],
                    'ref_date'=>$header['ref_date'],
                    'due_date'=>$header['due_date'],
                    'cheque_no'=>$header['cheque_no'],
                    'descriptions'=>$header['descriptions'],
                    'trans_code'=>$header['trans_code'],
                    'trans_series'=>$header['trans_series'],
                    'cash_id'=>$header['cash_id'],
                    'amount'=>$header['amount'],
                    'no_account'=>'',
                    'no_jurnal'=>'-1',
                    'is_posted'=>'0',
                    'enum_inout'=>'IN',
                    'db_version'=>'-',
                    'app_version'=>'-',
                    'is_void'=>'0',
                    'no_jurnal_void'=>'-1',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s'),
                    'update_location'=>$request->ip()
                ]);
            } else {
                $transid=$header['transid'];
                CashBank1::where('transid',$transid)
                ->update([
                    'transid'=>$transid,
                    'ref_date'=>$header['ref_date'],
                    'is_ge'=>$header['is_ge'],
                    'ref_date'=>$header['ref_date'],
                    'due_date'=>$header['due_date'],
                    'cheque_no'=>$header['cheque_no'],
                    'descriptions'=>$header['descriptions'],
                    'trans_code'=>$header['trans_code'],
                    'trans_series'=>$header['trans_series'],
                    'cash_id'=>$header['cash_id'],
                    'amount'=>$header['amount'],
                    'no_account'=>'',
                    'no_jurnal'=>'-1',
                    'is_posted'=>'0',
                    'enum_inout'=>'IN',
                    'db_version'=>'-',
                    'app_version'=>'-',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s'),
                    'update_location'=>$request->ip()
                ]);
                CashBank2::where('transid',$transid)->delete();
            }
            foreach($details as $line) {
                CashBank2::insert([
                    'transid'=>$transid,
                    'line_no'=>$line['line_no'],
                    'line_memo'=>$line['line_memo'],
                    'amount'=>$line['amount'],
                    'partner_id'=>$line['partner_id'],
                    'no_account'=>'',
                    'enum_type'=>$line['enum_type'],
                    'work_order_no'=>$line['work_order_no'],
                    'partner_id'=>$line['partner_id'],
                    'work_order_id'=>$line['work_order_id'],
                    'enum_partner'=>'3',
                    'control_account'=>'',
                    'description'=>''
                ]);
            }
            $CashBank=CashBank::find($header['cash_id']);
            $document_type=config('constants.cashbank.BANK_IN');
            CashBankTransaction::Generate($transid,$document_type);   
            PagesHelp::write_log($request,'OUT',-1,$transid,'IN '.$header['trans_code'].'-'.$header['trans_series']);
            DB::commit();
            $respon['sysid']=$transid;
            $respon['message']='Penerimaan Kas/bank berhasil';
            return response()->success('Success',$respon);
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
}
