<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class VehicleVariableCost extends Model
{
    protected $table = 'm_fleet_cost';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_invoice'=>'string',
        'is_fix'=>'string',
        'is_auto'=>'string',
        'is_active'=>'string',
        'fleet_cost'=>'float'
    ];
}
