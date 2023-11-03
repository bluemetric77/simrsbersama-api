<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PagesHelp;

class ItemsAdjustment1 extends Model
{
    protected $table = 't_items_adjustment1';
    protected $primaryKey = 'sysid';
    public $timestamps = TRUE;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'create_date';
    protected $casts = [
        'adjustment_cost' => 'float'
    ];

    public static function GenerateNumber($ref_date){
        $PREFIX = 'ISO';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }
}
