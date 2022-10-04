<?php

namespace App\Models\CS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CustomerPrice extends Model
{
    protected $table = 'm_customer_price';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_approved'=>'string',
        'standart_price'=>'float',
        'other_fee'=>'float',
        'fleet_price'=>'float',
        'standart_cost'=>'float',
        'is_active'=>'string'
    ];
}
