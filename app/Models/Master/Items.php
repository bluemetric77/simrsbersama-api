<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'm_item';
    protected $primaryKey = 'item_code';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded=[];
    protected $casts=[
        'convertion'=>'float',
        'on_hand'=>'float',
        'purchase_price'=>'float',
        'purchase_discount'=>'float',
        'purchase_tax'=>'float',
        'is_hold'=>'string',
        'is_active'=>'string'
    ];
}
