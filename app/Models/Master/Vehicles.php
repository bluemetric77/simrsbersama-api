<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $table = 'm_vehicle';
    protected $primaryKey = 'vehicle_no';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_active'=>'string',
        'is_volumetric'=>'string',
        'v_length'=>'int',
        'v_width'=>'int',
        'v_height'=>'int',
        'geofance_entered'=>'string',
        'log_sysid'=>'int',
        'work_order_sysid'=>'int'
    ];
}
