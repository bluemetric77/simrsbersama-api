<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class ItemInOut1 extends Model
{
    use HasFactory;
    protected $table = 't_items_inout1';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'sysid'=>'int',
        'cost'=>'float',
        'is_void'=>'string',
    ];

    public static function GenerateNumberIN($ref_date){
        $PREFIX = 'IGI';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }
    public static function GenerateNumberOUT($ref_date){
        $PREFIX = 'IGO';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }

}
