<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class ItemProduction1 extends Model
{
    use HasFactory;
    protected $table = 't_items_production1';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'sysid'=>'int',
        'output_standard'=>'float',
        'output_planning'=>'float',
        'output_production'=>'float',
        'cost_standard'=>'float',
        'cost_production'=>'float',
        'is_void'=>'string',
    ];

    public static function GenerateNumber($ref_date){
        $PREFIX = 'PRD';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }
}
