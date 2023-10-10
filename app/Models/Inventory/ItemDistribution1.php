<?php

namespace App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class ItemDistribution1 extends Model
{
    use HasFactory;
    protected $table = 't_items_distribution1';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'cost'=>'float',
        'jurnal_id'=>'int',
        'is_received'=>'string',
        'is_void'=>'string'
    ];

    public static function GenerateNumber($ref_date){
        $PREFIX = 'IID';
        return PagesHelp::GetDocseries($PREFIX,$ref_date);
    }

}
