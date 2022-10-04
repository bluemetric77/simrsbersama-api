<?php

namespace App\Models\Operation;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FleetOrder extends Model
{
    protected $table = 't_fleet_order';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'price'=>'float',
        'minimal_tonase'=>'float',
        'real_tonase'=>'float',
        'tonase'=>'float',
        'net_price'=>'float',
        'other_bill'=>'float',
        'over_night'=>'float',
        'total'=>'float',
        'expense'=>'float',
        'budget'=>'float',
        'closing_budget'=>'float',
        'standart_fleet_cost'=>'float',
        'dp_customer'=>'float',
        'is_posted'=>'string',
        'is_posted_ar'=>'string',
        'is_closed_order'=>'string'
    ];
    public static function Generate($pool_code,$ref_date){
        $date=date_create($ref_date);
        $year=date_format($date,"Y");
        $month=date_format($date,"m");
        $order=FleetOrder::selectRaw("work_order_no")
            ->whereRaw("YEAR(ref_date)=?",[$year])
            ->whereRaw("MONTH(ref_date)=?",[$month])
            ->where("pool_code",$pool_code)
            ->orderBY("work_order_no","desc")->first();
        if (!($order)) {
            $work_order_no= $pool_code.'-'.substr($year,2,2).str_pad($month,2,"0",STR_PAD_LEFT).'-00001';
        } else {
            $counter=substr($order->work_order_no,9,5);
            $counter=intval($counter)+1;
            $counter=str_pad($counter,5,"0",STR_PAD_LEFT);
            $work_order_no= $pool_code.'-'.substr($year,2,2).str_pad($month,2,"0",STR_PAD_LEFT).'-'.$counter;
        }  
        return $work_order_no;
    }
}
