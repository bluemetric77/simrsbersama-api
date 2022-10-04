<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class COA extends Model
{
    protected $table = 'm_account';
    protected $primaryKey = 'account_no';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded=[];
    protected $casts=[
       'is_header'=>'string',
       'is_cash_bank'=>'string',
       'is_posted'=>'string',
       'is_active'=>'string'
    ];
}
