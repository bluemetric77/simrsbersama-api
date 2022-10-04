<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Objects extends Model
{
    protected $table = 'o_objects';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $casts = [
        'parent_sysid'=>'int',
        'object_level'=>'int',
    ];
}

