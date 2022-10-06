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
        'is_received'=>'boolean',
        'is_sales'=>'boolean',
        'is_distribution'=>'boolean',
        'is_active'=>'boolean',
    ];
}
