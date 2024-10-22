<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class VarSystem extends Model
{
    protected $table = 'o_system';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    protected $casts = [
        'parent_sysid'=>'int',
    ];
}

