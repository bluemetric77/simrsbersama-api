<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'm_department';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $guarded =[];
    protected $casts = [
        'is_active'=>'boolean',
        'is_executive'=>'boolean'
    ];
}
