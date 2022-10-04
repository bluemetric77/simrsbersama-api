<?php

namespace App\Models\Finance;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CashBankUJO2 extends Model
{
    protected $table = 't_fleet_expense_cashier2';
    protected $primaryKey = ['transid', 'line_no'];
    public $incrementing = false;
    protected $keyType='string';
    public $timestamps = false;
    protected $guarded =[];
    protected $casts = [
        'budget'=>'float',
        'expense_out'=>'float',
        'expense'=>'float'
    ];
}
