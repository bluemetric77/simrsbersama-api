<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardCode extends Model
{
    use HasFactory;
    protected $table="m_standard_code";
    protected $primaryKey ='sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts =[
        'is_active'=>'string'
    ];
}
