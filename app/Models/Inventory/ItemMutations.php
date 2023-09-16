<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class ItemMutations extends Model
{
    use HasFactory;
    protected $table = 't_item_mutations';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
    protected $casts=[
        'mutation'=>'float',
        'on_hand'=>'float',
        'on_order'=>'float',
        'on_demand'=>'float',
        'cogs'=>'float',
        'out1'=>'float',
        'out2'=>'float',
        'out3'=>'float',
        'is_hold'=>'string',
        'minimum_stock'=>'float',
        'maximum_stock'=>'float',
        'is_visible'=>'string'
    ];
}
