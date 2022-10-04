<?php

namespace App\Helpers;

use App\Models\Operation\FleetOrder;
use App\Models\Operation\FleetExpense1;
use App\Models\Operation\FleetExpense2;
use App\Models\Finance\CashBankTransaction;
use App\Models\Finance\CashBank1;
use App\Models\Finance\CashBank2;
use App\Models\Finance\CashBankUJO1;
use App\Models\Finance\CashBankUJO2;
use App\Models\Accounting\Journal1;
use App\Models\Accounting\Journal2;
use App\Models\Accounting\GeneralAcc;
use App\Models\Master\CashBank;
use App\Models\Master\COA;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PagesHelp;
use Accounting;

class AutoJurnal extends Controller{

    public function jurnal_droping($sysid,$request) {
        /* Ayat Silang
             Kas/Bank
         */
        $ret['state']=true;
        $ret['message']=''; 
        $jurnal_type=config('constants.jurnal_type.em_JurnalDropingUJO');
        $document_type=config('constants.cashbank.DROPING_UJO');
        $data=CashBankTransaction::from("t_cashbank_transaction as a")
            ->selectRaw("a.transid,a.ref_date,a.doc_number,a.cashbank_source,a.descriptions,ABS(IFNULL(a.amount,0)) as amount,
            IFNULL(a.no_jurnal,-1) as no_jurnal,a.trans_code,a.trans_series,b.no_account,IFNULL(c.account_no,'') AS ayat_silang,
            a.linkdoc_number")
            ->leftjoin('m_cash_operation as b','a.cashbank_source','=','b.cash_id')
            ->leftjoin('m_cash_operation_link as c',function($join) {
                $join->on('a.cashbank_source','=','c.cash_id');
                $join->on('a.cashbank_destination','=','c.link_id');
            })
            ->where('a.transid',$sysid)
            ->where('a.document_type',$document_type)
            ->first();
        if ($data){
            $amount=floatval($data->amount);
            $realdate = date_create($data->ref_date);
            $year_period = date_format($realdate, 'Y');
            $month_period = date_format($realdate, 'm');
            if ($data->no_jurnal==-1){
                $no_jurnal=Journal1::max('transid')+1;
                Journal1::insert([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->linkdoc_number,
                  'reference2'=>'',
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>$data->trans_code,
                  'trans_series'=>$data->trans_series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>$jurnal_type,
                  'notes'=>$data->descriptions
              ]);      
            } else {
                $no_jurnal=$data->no_jurnal;
                Accounting::rollback($no_jurnal);    
                Journal1::where('transid',$no_jurnal)
                ->update([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->linkdoc_number,
                  'reference2'=>'',
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>$data->trans_code,
                  'trans_series'=>$data->trans_series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>$jurnal_type,
                  'notes'=>$data->descriptions
                ]);
            }
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>1,
                'no_account'=>$data->ayat_silang,
                'line_memo'=>$data->descriptions,
                'reference1'=>$data->linkdoc_number,
                'reference2'=>'',
                'due_date'=>$data->ref_date,
                'debit'=>$data->amount,
                'credit'=>0,
                'crdebit'=>$data->amount,
                'crcredit'=>0,
            ]);
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>2,
                'no_account'=>$data->no_account,
                'line_memo'=>$data->descriptions,
                'reference1'=>$data->expense_no,
                'reference2'=>'',
                'due_date'=>$data->ref_date,
                'debit'=>0,
                'credit'=>$data->amount,
                'crdebit'=>0,
                'crcredit'=>$data->amount,
            ]);
            $info=Accounting::posting($no_jurnal,$request);
            if ($info['state']==true){
                CashBankTransaction::where('transid',$sysid)
                ->where('document_type',$document_type)
                ->update([
                    'no_jurnal'=>$no_jurnal,
                    'is_posted'=>'1'
                ]);
            }
            $ret['state']=$info['state'];
            $ret['message']=$info['message'];        
            $ret['no_jurnal']=$no_jurnal;        
        } else {
            $ret['state']=false;
            $ret['message']='Data tidak ditemukan'; 
        }
        return $ret;
    }


    public function jurnal_receive_droping($sysid,$request) {
        /* Ayat Silang
             Kas/Bank
         */
        $ret['state']=true;
        $ret['message']=''; 
        $jurnal_type=config('constants.jurnal_type.em_JurnalDropingUJO');
        $document_type=config('constants.cashbank.RECEIVE_UJO');
        $data=CashBankTransaction::from("t_cashbank_transaction as a")
            ->selectRaw("a.transid,a.ref_date,a.doc_number,a.cashbank_source,a.descriptions,ABS(IFNULL(a.amount,0)) as amount,
            IFNULL(a.no_jurnal,-1) as no_jurnal,a.trans_code,a.trans_series,b.no_account,IFNULL(c.account_no,'') AS ayat_silang,
            a.linkdoc_number")
            ->leftjoin('m_cash_operation as b','a.cashbank_source','=','b.cash_id')
            ->leftjoin('m_cash_operation_link as c',function($join) {
                $join->on('a.cashbank_source','=','c.cash_id');
                $join->on('a.cashbank_destination','=','c.link_id');
            })
            ->where('a.transid',$sysid)
            ->where('a.document_type',$document_type)
            ->first();
        if ($data){
            $amount=floatval($data->amount);
            $realdate = date_create($data->ref_date);
            $year_period = date_format($realdate, 'Y');
            $month_period = date_format($realdate, 'm');
            if ($data->no_jurnal==-1){
                $no_jurnal=Journal1::max('transid')+1;
                Journal1::insert([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->linkdoc_number,
                  'reference2'=>'',
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>$data->trans_code,
                  'trans_series'=>$data->trans_series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>$jurnal_type,
                  'notes'=>$data->descriptions
              ]);      
            } else {
                $no_jurnal=$data->no_jurnal;
                Accounting::rollback($no_jurnal);    
                Journal1::where('transid',$no_jurnal)
                ->update([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->linkdoc_number,
                  'reference2'=>'',
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>$data->trans_code,
                  'trans_series'=>$data->trans_series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>$jurnal_type,
                  'notes'=>$data->descriptions
                ]);
            }
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>1,
                'no_account'=>$data->no_account,
                'line_memo'=>$data->descriptions,
                'reference1'=>$data->expense_no,
                'reference2'=>'',
                'due_date'=>$data->ref_date,
                'debit'=>$data->amount,
                'credit'=>0,
                'crdebit'=>$data->amount,
                'crcredit'=>0,
            ]);
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>2,
                'no_account'=>$data->ayat_silang,
                'line_memo'=>$data->descriptions,
                'reference1'=>$data->linkdoc_number,
                'reference2'=>'',
                'due_date'=>$data->ref_date,
                'debit'=>0,
                'credit'=>$data->amount,
                'crdebit'=>0,
                'crcredit'=>$data->amount,
            ]);
            $info=Accounting::posting($no_jurnal,$request);
            if ($info['state']==true){
                CashBankTransaction::where('transid',$sysid)
                ->where('document_type',$document_type)
                ->update([
                    'no_jurnal'=>$no_jurnal,
                    'is_posted'=>'1'
                ]);
            }
            $ret['state']=$info['state'];
            $ret['message']=$info['message'];        
            $ret['no_jurnal']=$no_jurnal;        
        } else {
            $ret['state']=false;
            $ret['message']='Data tidak ditemukan'; 
        }
        return $ret;
    }

    public function jurnal_ujo($sysid,$request) {
        /* Kasir UJO
           Biaya
             Kas/Bank
         */
        $ret['state']=true;
        $ret['message']=''; 
        $jurnal_type=config('constants.jurnal_type.em_JurnalUJO');
        $data=CashBankUJO1::from('t_fleet_expense_cashier1 as a')
        ->selectRaw("a.transid,a.expense_no,a.ref_date,a.trans_code,a.trans_series,a.no_jurnal,a.pool_code,
        a.expense,a.adm_fee,a.total,b.no_account,a.cash_id,a.descriptions")
        ->join('m_cash_operation as b','a.cash_id','=','b.cash_id')
        ->where('a.transid',$sysid)->first();
        if ($data){
            $adm_fee=floatval($data->adm_fee);
            $total=floatval($data->total);
            $realdate = date_create($data->ref_date);
            $year_period = date_format($realdate, 'Y');
            $month_period = date_format($realdate, 'm');
            if ($data->no_jurnal==-1){
                $no_jurnal=Journal1::max('transid')+1;
                Journal1::insert([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->expense_no,
                  'reference2'=>'',
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>$data->trans_code,
                  'trans_series'=>$data->trans_series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>$jurnal_type,
                  'notes'=>$data->descriptions
              ]);      
            } else {
                $no_jurnal=$data->no_jurnal;
                $series=$data->trans_series;
                Accounting::rollback($no_jurnal);    
                Journal1::where('transid',$no_jurnal)
                ->update([
                  'transid'=>$no_jurnal,  
                  'ref_date'=>$data->ref_date,
                  'reference1'=>$data->expense_no,
                  'reference2'=>'',
                  'posting_date'=>$data->ref_date,
                  'is_posted'=>'1',
                  'trans_code'=>$data->trans_code,
                  'trans_series'=>$data->trans_series,
                  'fiscal_year'=>$year_period,
                  'fiscal_month'=>$month_period,
                  'transtype'=>$jurnal_type,
                  'notes'=>$data->descriptions
                ]);
            }
            $line=0;
            $costs=CashBankUJO2::where("transid",$sysid)->where("expense","<>","0")->get();
            foreach($costs as $cost){
                $line++;
                Journal2::insert([
                    'transid'=>$no_jurnal,
                    'line_no'=>$line,
                    'no_account'=>$cost->account_no,
                    'line_memo'=>$cost->descriptions.' - '.$data->expense_no,
                    'reference1'=>$data->expense_no,
                    'reference2'=>'',
                    'due_date'=>$data->ref_date,
                    'debit'=>$cost->expense,
                    'credit'=>0,
                    'crdebit'=>$cost->expense,
                    'crcredit'=>0,
                ]);
            }
            /* Biaya Admin */
            if ($data->admin_fee>0){
                $acc=GeneralAcc::selectRaw("unbill_account,revenue_account")->where('id',1)->first();
                $line++;
                Journal2::insert([
                    'transid'=>$no_jurnal,
                    'line_no'=>$line,
                    'no_account'=>'7141000004',
                    'line_memo'=>$data->descriptions,
                    'reference1'=>$data->expense_no,
                    'reference2'=>'',
                    'due_date'=>$data->ref_date,
                    'debit'=>$data->admin_fee,
                    'credit'=>0,
                    'crdebit'=>$data->admin_fee,
                    'crcredit'=>0,
                ]);
            }
            $line++;
            Journal2::insert([
                'transid'=>$no_jurnal,
                'line_no'=>$line,
                'no_account'=>$data->no_account,
                'line_memo'=>$data->descriptions,
                'reference1'=>$data->expense_no,
                'reference2'=>'',
                'due_date'=>$data->ref_date,
                'debit'=>0,
                'credit'=>$data->expense,
                'crdebit'=>0,
                'crcredit'=>$data->expense,
            ]);
            $info=Accounting::posting($no_jurnal,$request);
            if ($info['state']==true){
                CashBankUJO1::where('transid',$sysid)
                ->update([
                    'no_jurnal'=>$no_jurnal
                ]);
            }
            $ret['state']=$info['state'];
            $ret['message']=$info['message'];        
            $ret['no_jurnal']=$no_jurnal;        
        } else {
            $ret['state']=false;
            $ret['message']='Data tidak ditemukan'; 
        }
        return $ret;
    }
}
