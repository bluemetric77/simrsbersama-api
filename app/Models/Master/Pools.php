<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Pools extends Model
{
    protected $table = 'm_pool';
    protected $primaryKey = 'pool_code';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_active'=>'string'
    ];
}
