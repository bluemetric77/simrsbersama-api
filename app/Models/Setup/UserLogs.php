<?php

namespace App\Models\Setup;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    protected $table = 't_user_logs';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    protected $guarded =[];
}
