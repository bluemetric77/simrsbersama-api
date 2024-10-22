<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SeriesJournal extends Model
{
    protected $table = 'o_series_jurnal';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $casts = [
        'counter'=>'int',
    ];
}

