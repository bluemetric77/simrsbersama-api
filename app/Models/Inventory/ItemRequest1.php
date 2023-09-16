<?php

namespace App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class ItemRequest1 extends Model
{
    use HasFactory;
    protected $table = 't_items_request1';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_process'=>'string',
        'is_void'=>'string',
        'is_approved'=>'string',
        'conversion'=>'float',
        'qty_request'=>'float',
        'qty_distribustion'=>'float',
        'qty_received'=>'float',
    ];

    public static function GenerateNumber($ref_date){
        $PREFIX = 'ISR';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }

}
