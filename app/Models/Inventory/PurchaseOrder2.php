<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder2 extends Model
{
    use HasFactory;
    protected $table = 't_purchase_order2';
    protected $primaryKey = ['sysid','line_no'];
    public $incrementing = false;
    public $timestamps = false;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'conversion'=>'float',
        'qty_draft'=>'float',
        'qty_order'=>'float',
        'price'=>'float',
        'prc_discount1'=>'float',
        'discount1'=>'float',
        'prc_discount2'=>'float',
        'discount2'=>'float',
        'prc_tax'=>'float',
        'tax'=>'float',
        'total'=>'float',
        'qty_received'=>'float',
        'request_qty'=>'float',
        'request_line'=>'int',
        'request_id'=>'int',
        'conversion'=>'float'
    ];
}
