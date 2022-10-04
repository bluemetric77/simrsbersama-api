<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class VehicleGroup extends Model
{
    protected $table = 'm_vehicle_group';
    protected $primaryKey = 'vehicle_type';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_active'=>'string'
    ];
}
