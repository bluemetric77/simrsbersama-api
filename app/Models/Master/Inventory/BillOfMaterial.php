<?php

namespace App\Models\Master\Inventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    protected $table = 'm_items_bom';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    protected $guarded =[];
    protected $casts = [
        'quantity_bom'=>'float',
        'cogs'=>'float'
    ];
}
