<?php

namespace App\Models\Finance;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CashBankUJO1 extends Model
{
    protected $table = 't_fleet_expense_cashier1';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_canceled'=>'string',
        'no_jurnal'=>'int',
        'expense'=>'float',
        'adm_fee'=>'float',
        'total'=>'float'
    ];
}
