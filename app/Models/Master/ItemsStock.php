<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ItemsStock extends Model
{
    protected $table = 'm_item_stock';
    protected $primaryKey = ['warehouse_id','item_code'];
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded=[];
    protected $casts=[
        'on_hand'=>'float',
        'on_demand'=>'float',
        'on_order'=>'float',
        'minimum_stock'=>'float',
        'maximum_stock'=>'float',
        'is_hold'=>'string'
    ];
}
