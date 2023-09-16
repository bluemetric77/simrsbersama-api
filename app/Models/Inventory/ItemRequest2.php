<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequest2 extends Model
{
    use HasFactory;
    protected $table = 't_items_request2';
    protected $primaryKey = ['sysid','line_no'];
    public $incrementing = false;
    public $timestamps = false;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_process'=>'string',
        'is_void'=>'string',
        'is_approved'=>'float',
        'conversion'=>'float',
        'qty_request'=>'float',
        'qty_distribustion'=>'float',
        'qty_received'=>'float',
        'qty_order'=>'float'
    ];
}
