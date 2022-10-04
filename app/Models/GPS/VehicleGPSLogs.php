<?php

namespace App\Models\GPS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class VehicleGPSLogs extends Model
{
    protected $table = 't_vehicle_logs';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
}
