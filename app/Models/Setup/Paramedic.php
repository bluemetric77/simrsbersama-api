<?php

namespace App\Models\Setup;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Paramedic extends Model
{
    protected $table = 'm_paramedic';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_active'=>'boolean',
        'is_permanent'=>'boolean',
        'is_internal'=>'boolean',
        'is_have_tax'=>'boolean',
        'is_transfer'=>'boolean',
        'is_email_reports'=>'boolean',
    ];
}
