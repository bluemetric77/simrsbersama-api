<?php

namespace App\Models\Master\Inventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'm_items';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_price_rounded'=>'boolean',
        'is_expired_control'=>'boolean',
        'is_sales'=>'boolean',
        'is_purchase'=>'boolean',
        'is_production'=>'boolean',
        'is_material'=>'boolean',
        'is_cosignment'=>'boolean',
        'is_formularium'=>'boolean',
        'is_employee'=>'boolean',
        'is_inhealth'=>'boolean',
        'is_bpjs'=>'boolean',
        'is_national'=>'boolean',
        'cogs'=>'float',
        'hna'=>'float',
        'het_price'=>'float',
        'on_hand'=>'float',
        'on_hand_unit'=>'float',
        'is_active'=>'boolean',
    ];
}
