<?php

namespace App\Models\CS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StandartCostDetail extends Model
{
    protected $table = 'm_standart_fleet_cost2';
    protected $primaryKey = ['cost_id', 'line_no'];
    protected $keyType='string';
    public $incrementing = false;
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'fleet_cost'=>'float',
        'is_fix'=>'string',
        'is_invoice'=>'string',
        'is_auto'=>'string',
        'fleet_cost'=>'float'
    ];
}
