<?php

namespace App\Models\CS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StandartCost extends Model
{
    protected $table = 'm_standart_fleet_cost1';
    protected $primaryKey = 'cost_id';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_approved'=>'string',
        'standart_price'=>'float',
        'other_fee'=>'float',
        'fleet_price'=>'float',
        'is_active'=>'string'
    ];
}
