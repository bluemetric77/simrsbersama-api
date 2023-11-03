<?php

namespace App\Models\Master\Inventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'm_warehouse';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_received'=>'string',
        'is_sales'=>'string',
        'is_distribution'=>'string',
        'is_active'=>'string',
        'is_direct_purchase'=>'string',
        'is_production'=>'string'
    ];
}
