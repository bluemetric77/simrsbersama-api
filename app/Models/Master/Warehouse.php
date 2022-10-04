<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'm_warehouse';
    protected $primaryKey = 'warehouse_id';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_allow_negatif'=>'string',
        'is_allow_receive'=>'string',
        'is_allow_transfer'=>'string',
        'is_auto_transfer'=>'string',
        'is_active'=>'string'
    ];
}
