<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class PurchaseOrder1 extends Model
{
    use HasFactory;
    protected $table = 't_purchase_order1';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_posted'=>'string',
        'is_void'=>'string',
        'amount'=>'float',
        'discount1'=>'float',
        'discount2'=>'float',
        'tax'=>'float',
        'total'=>'float',
        'is_tax'=>'string',
        'conversion'=>'float',
        'qty_order'=>'float',
        'price'=>'float',
        'prc_discount1'=>'float',
        'prc_discount2'=>'float',
        'prc_tax'=>'float',
        'qty_received'=>'float',        
    ];

    public static function GenerateNumber($ref_date){
        $PREFIX = 'POI';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }    

}
