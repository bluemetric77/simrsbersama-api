<?php

namespace App\Models\Setup;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ParamedicProfile extends Model
{
    protected $table = 'm_paramedic1';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    protected $guarded =[];
}
