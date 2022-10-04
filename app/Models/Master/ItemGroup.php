<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model
{
    protected $table = 'm_item_group';
    protected $primaryKey = 'item_group';
    protected $keyType='string';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
}
