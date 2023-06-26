<?php

namespace App\Models\Master\Inventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DrugInformations extends Model
{
    protected $table = 'm_items_informations';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    protected $guarded =[];
    protected $casts = [
        'is_generic'=>'string',
    ];
}
