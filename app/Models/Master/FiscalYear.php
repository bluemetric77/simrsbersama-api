<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    protected $table = 'm_fiscal_year';
    protected $primaryKey = 'fiscal_id';
    public $timestamps = false;
    const CREATED_AT = 'update_timestamp';
    const UPDATED_AT = 'update_timestamp';
    protected $guarded =[];
    protected $casts = [
        'is_closed'=>'string',
    ];

    public static function IsValid($refdate){
        $info['state']=false;
        $info['message']='NOT_FOUND';
        $realdate = date_create($refdate);
		$year_period = date_format($realdate, 'Y');
        $month_period = date_format($realdate, 'm');
        $fiscal=DB::table('m_fiscal_year')->select('enum_status')
        ->where('start_date','<=',$refdate)
        ->where('end_date','>=',$refdate)
        ->first();
        if (!($fiscal)){
            $info['message']="Periode akunting untuk tanggal ".date_format($refdate,'d-m-Y')." tidak ada";
        } else {
            if ($fiscal->enum_status=='Close') {
                $info['message']="Periode akunting untuk tanggal ".date_format($realdate,'d-m-Y')." sudah ditutup";
            } else {
                $info['state']=true;
                $info['message']='';
            }  
        }
        return $info;
    }

}
