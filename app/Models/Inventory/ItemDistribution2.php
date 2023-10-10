<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDistribution2 extends Model
{
    use HasFactory;
    protected $table = 't_items_distribution2';
    protected $primaryKey = ['sysid','line_no'];
    public $incrementing = false;
    public $timestamps = false;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'convertion'=>'float',
        'quantity_request'=>'float',
        'quantity_distribution'=>'float',
        'item_cost'=>'float',
        'line_cost'=>'float',
        'quantity_update'=>'float'
    ];
}
