<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PagesHelp;

class ItemMutationsMonthly extends Model
{
    use HasFactory;
    protected $table = 't_item_mutations_monthly';
    protected $primaryKey = 'sysid';
    public $timestamps = false;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $guarded =[];
}
