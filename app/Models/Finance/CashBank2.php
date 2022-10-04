<?php

namespace App\Models\Finance;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CashBank2 extends Model
{
    protected $table = 't_cash_bank2';
    protected $primaryKey = ['transid', 'line_no','no_account'];
    public $incrementing = false;
    protected $keyType='string';
    public $timestamps = false;
    protected $guarded =[];
    protected $casts = [
        'is_downpayment'=>'string',
        'is_ar'=>'int',
        'is_linked'=>'string',
        'amount'=>'float',
    ];
}
