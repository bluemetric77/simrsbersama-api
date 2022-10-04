<?php

namespace App\Models\Accounting;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GeneralAcc extends Model
{
    protected $table = 'o_account_general';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded =[];
}
