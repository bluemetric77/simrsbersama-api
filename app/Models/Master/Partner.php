<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'm_partner';
    protected $primaryKey = 'partner_id';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded=[];
    protected $casts=[
       'is_active'=>'string',
       'maximum_credit'=>'float',
       'fee_of_storage'=>'float',
       'percent_of_storage'=>'float',
       'minimum_tonase'=>'float',
       'fee_of_tonase'=>'float'
    ];
}
