<?php

namespace App\Models\Finance;
use App\Models\Finance\CashBankUJO1;
use App\Models\Finance\CashBank1;
use App\Models\Finance\CashBank2;
use App\Models\Master\CashBank;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CashBankTransaction extends Model
{
    protected $table = 't_cashbank_transaction';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_posted'=>'string',
        'linkdocument_id'=>'int',
        'is_received'=>'string',
        'is_void'=>'string',
        'request_id'=>'id',
        'request_line'=>'int',
        'amount'=>'float',
        'no_jurnal'=>'int',
        'debet'=>'float',
        'credit'=>'float'
    ];

    public static function Generate($sysid=-1,$document_type=''){

        if ($document_type==config('constants.cashbank.UJO')) {
           $records=CashBankUJO1::where('sysid',$sysid)->get();
        } else if ($document_type==config('constants.cashbank.BANK_OUT')) {
           $records=CashBank1::from("t_cash_bank1 as a")
           ->selectRaw("a.transid as sysid,a.ref_date,b.line_memo as descriptions,0 - IFNULL(b.amount,0) as total,a.trans_code,a.trans_series,
                        a.no_jurnal,a.cash_id,a.is_posted,'' as pool_code,'' as project_id,a.update_userid,a.update_timestamp")
           ->join("t_cash_bank2 as b","a.transid","=","b.transid")
           ->where('a.transid',$sysid)
           ->where('a.enum_inout','OUT')
           ->get();
        } else if ($document_type==config('constants.cashbank.BANK_IN')) {
           $records=CashBank1::from("t_cash_bank1 as a")
           ->selectRaw("a.transid as sysid,a.ref_date,b.line_memo as descriptions,IFNULL(b.amount,0) as total,a.trans_code,a.trans_series,
                        a.no_jurnal,a.cash_id,a.is_posted,'' as pool_code,'' as project_id,a.update_userid,a.update_timestamp")
           ->join("t_cash_bank2 as b","a.transid","=","b.transid")
           ->where('a.transid',$sysid)
           ->where('a.enum_inout','IN')
           ->get();
        }
        
        if (isset($records)) {
            CashBankTransaction::where('linkdocument_id',$sysid) 
                    ->where('document_type',$document_type)
                    ->delete();
            foreach($records as $data) {
                $CashBank=CashBank::where("cash_id",$data->cash_id)->first();
                $transid=CashBankTransaction::max("transid")+1;
                $data->is_posted='1';
                CashBankTransaction::insert([
                    'transid'=>$transid,
                    'doc_number'=>$data->trans_code.'-'.$data->trans_series,
                    'ref_date'=>$data->ref_date,
                    'cashbank_source'=>$data->cash_id,
                    'descriptions'=>$data->descriptions,
                    'amount'=>$data->total,
                    'no_jurnal'=>$data->no_jurnal,
                    'trans_code'=>$data->trans_code,
                    'trans_series'=>$data->trans_series,
                    'no_jurnal'=>$data->no_jurnal,
                    'is_posted'=>$data->is_posted,
                    'linkdocument_id'=>$sysid,
                    'linkdoc_number'=>$data->trans_code.'-'.$data->trans_series,
                    'document_type'=>$document_type,
                    'pool_code'=>$data->pool_code,
                    'project_id'=>$data->project_id,
                    'is_void'=>'0',
                    'cashbank_sname'=>isset($CashBank->account_name) ? $CashBank->account_name :'',
                    'update_userid'=>$data->update_userid,
                    'update_timestamp'=>$data->update_timestamp
                ]) ;
            }
        }
    }
}
