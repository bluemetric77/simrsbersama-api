<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class VoucherJurnal extends Model
{
    protected $table = 'm_voucher_jurnal';
    protected $primaryKey = 'voucher_code';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts=[
        'is_active'=>'string'
    ];
}
