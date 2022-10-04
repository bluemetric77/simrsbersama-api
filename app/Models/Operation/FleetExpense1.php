<?php

namespace App\Models\Operation;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FleetExpense1 extends Model
{
    protected $table = 't_fleet_expense1';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'price'=>'float',
        'other_expense'=>'float',
        'dp_customer'=>'float',
        'total'=>'float',
        'cashier'=>'float',
        'ar_amount'=>'float',
        'ar_payment'=>'float',
        'adm_fee'=>'float',
        'dp_valid'=>'string',
        'is_closed'=>'string',
        'is_primary'=>'string',
        'is_authorize'=>'string',
        'is_canceled'=>'string',
        'cash_amount'=>'float',
        'standart'=>'float'
    ];
}
