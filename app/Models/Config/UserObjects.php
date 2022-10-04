<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserObjects extends Model
{
    protected $table = 'o_users_access';
    protected $primaryKey = ['user_sysid','object_sysid'];
    public $incrementing = false;
    protected $primaryType= 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
