<?php

namespace App\Models\Setup;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ServiceClass extends Model
{
    protected $table = 'm_class';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_base_price'=>'boolean',
        'is_price_class'=>'boolean',
        'is_price_service'=>'boolean',
        'is_price_bpjs'=>'boolean',
        'minimum_deposit'=>'float',
        'factor_inpatient'=>'float',
        'factor_service'=>'float',
        'factor_pharmacy'=>'float'
    ];
}
