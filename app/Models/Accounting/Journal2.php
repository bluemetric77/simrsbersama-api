<?php

namespace App\Models\Accounting;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Journal2 extends Model
{
    protected $table = 't_jurnal2';
    protected $primaryKey = ['transid', 'line_no'];
    public $incrementing = false;
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'debit' => 'float',
        'credit' => 'float',
        'is_verified'=>'string',
        'is_void'=>'string',
        'project'=>'string',
        'no_account'=>'string',
        'is_void'=>'string'
    ];    
}
