<?php

namespace App\Models\Setup;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ParamedicPriceGroup extends Model
{
    protected $table = 'm_price_paramedic_groups';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
}
