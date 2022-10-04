<?php

namespace App\Models\Operation;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FleetOrderRowCost extends Model
{
    protected $table = 't_fleet_cost';
    protected $primaryKey = 'transid';
    public $incrementing = false;
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'standar_budget'=>'float',
        'budget'=>'float',
        'expense'=>'float',
        'is_invoice'=>'string',
        'base_cost'=>'float',
        'qty'=>'float',
        'percent_cost'=>'float',
        'fee'=>'float',
    ];
}
