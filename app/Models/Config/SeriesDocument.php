<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SeriesDocument extends Model
{
    protected $table = 'o_series_document';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $casts = [
        'numbering'=>'int',
    ];
}

