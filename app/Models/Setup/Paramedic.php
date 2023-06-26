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
        'is_active'=>'string',
        'is_permanent'=>'string',
        'is_internal'=>'string',
        'is_have_tax'=>'string',
        'is_transfer'=>'string',
        'is_email_reports'=>'string',
    ];
}
