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
        'is_base_price'=>'string',
        'is_price_class'=>'string',
        'is_price_service'=>'string',
        'is_price_bpjs'=>'string',
        'minimum_deposit'=>'float',
        'factor_inpatient'=>'float',
        'factor_service'=>'float',
        'factor_pharmacy'=>'float'
    ];
}
