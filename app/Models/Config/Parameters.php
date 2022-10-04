<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $table = 'o_parameters';
    protected $primaryKey = 'sysid';
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $casts = [
        'is_selected' => 'string'
    ];    
}
