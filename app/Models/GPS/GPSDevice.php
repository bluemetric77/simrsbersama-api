<?php

namespace App\Models\GPS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GPSDevice extends Model
{
    protected $table = 'm_gps';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_calculate'=>'string',
        'is_active'=>'string',
        'gps_signal'=>'string',
    ];
}
