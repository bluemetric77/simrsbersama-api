<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProduction2 extends Model
{
    use HasFactory;
    protected $table = 't_items_production2';
    protected $primaryKey = ['sysid','line_no'];
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded =[];
    protected $casts = [
        'sysid'=>'int',
        'item_sysid'=>'int',
        'line_no'=>'int',
        'quantity_standard'=>'float',
        'quantity_item'=>'float',
        'item_cost'=>'float',
        'line_cost'=>'float',
    ];
}
