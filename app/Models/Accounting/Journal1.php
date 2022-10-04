<?php

namespace App\Models\Accounting;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class Journal1 extends Model
{
    protected $table = 't_jurnal1';
    protected $primaryKey = 'transid';
    public $timestamps = TRUE;
    protected $hidden=['update_userid','update_timestamp'];
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'debit' => 'float',
        'credit' => 'float',
        'is_void'=>'string',
        'is_verified'=>'string',
        'project'=>'string'
    ];    

    public static function GenerateNumber($trans_code,$ref_date){
        return PagesHelp::GetVoucherseries($trans_code,$ref_date);
    }
}
