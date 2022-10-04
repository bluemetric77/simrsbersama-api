<?php

namespace App\Models\Finance;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CashBank1 extends Model
{
    protected $table = 't_cash_bank1';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_ge'=>'string',
        'is_posted'=>'string',
        'is_void'=>'string',
        'amount'=>'float',
        'no_jurnal'=>'int'
    ];
}
