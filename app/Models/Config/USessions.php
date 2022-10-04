<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class USessions extends Model
{
    protected $table = 'o_sessions';
    protected $primaryKey = 'sign_code';
    protected $primaryType= 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
