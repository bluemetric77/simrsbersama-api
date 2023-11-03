<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInOut2 extends Model
{
    use HasFactory;
    protected $table = 't_items_inout2';
    protected $primaryKey = ['sysid','line_no'];
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded =[];
    protected $casts = [
        'sysid'=>'int',
        'item_sysid'=>'int',
        'line_no'=>'int',
        'convertion'=>'float',
        'quantity_item'=>'float',
        'quantity_update'=>'float',
        'item_cost'=>'float',
        'line_cost'=>'float',
        'quantity_update'=>'float',
    ];
}
