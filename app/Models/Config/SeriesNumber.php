<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SeriesNumber extends Model
{
    protected $table = 'm_series_number';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    protected $casts = [
        'parent_sysid'=>'int',
    ];
}

