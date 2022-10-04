<?php

namespace App\Models\Operation;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FleetExpense2 extends Model
{
    protected $table = 't_fleet_expense2';
    protected $primaryKey = ['transid', 'line_no'];
    public $incrementing = false;
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'standart_budget'=>'float',
        'expense_budget'=>'float',
        'expense'=>'float',
        'is_fix'=>'string',
    ];
}
