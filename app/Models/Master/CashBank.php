<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CashBank extends Model
{
    protected $table = 'm_cash_operation';
    protected $primaryKey = 'cash_id';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_headoffice'=>'string',
        'is_bank'=>'string',
        'is_operasional'=>'string',
        'is_usedinvoice'=>'string',
        'is_active'=>'string'
    ];
}
