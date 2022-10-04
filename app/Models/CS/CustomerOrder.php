<?php

namespace App\Models\CS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    protected $table = 't_customer_order';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'price'=>'float',
        'standart_price'=>'float',
        'qty'=>'float',
        'fleet_price'=>'float',
        'fleet_cost'=>'float',
        'is_transactionlink'=>'string',
        'is_closed_order'=>'string',
        'is_closed_expense'=>'string'
    ];
    public static function GenerateNumber($refdate) {
        //$date=date_create($refdate);
        $year=date('Y');
        $month=date('m');
        $order=CustomerOrder::selectRaw("order_no")
            ->whereRaw("YEAR(entry_date)=?",[$year])
            ->whereRaw("MONTH(entry_date)=?",[$month])
            ->orderBY("order_no","desc")->first();
        if (!($order)) {
            $order_no= 'ORD-'.substr($year,2,2).str_pad($month,2,"0",STR_PAD_LEFT).'-0001';
        } else {
            $counter=substr($order->order_no,9,4);
            $counter=intval($counter)+1;
            $counter=str_pad($counter,4,"0",STR_PAD_LEFT);
            $order_no= 'ORD-'.substr($year,2,2).str_pad($month,2,"0",STR_PAD_LEFT).'-'.$counter;
        }  
        return $order_no;
    }
}
