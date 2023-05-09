<?php

namespace App\Models\Master\Inventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Manufactur extends Model
{
    protected $table = 'm_manufactur';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts = [
        'is_active'=>'string',
    ];
}
