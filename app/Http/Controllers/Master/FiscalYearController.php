<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\FiscalYear;
use PagesHelp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FiscalYearController extends Controller
{
    public function get(Request $request)
    {
        $year_period=$request->year_period;
        for ($x = 0; $x <= 11; $x++) {
            $month=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            if (!(FiscalYear::where("year_period",$year_period)
            ->where("month_period",$x+1)->exists())) {
                $year_id=intval($year_period)+(10 * ($x+1));
                $descriptions=$month[$x].' '.$year_period;
                $start_date=$year_period.'-'.strval($x+1).'-01';
                $end_date=date("Y-m-t",strtotime($start_date));    
                FiscalYear::insert([
                    'fiscal_id'=>$year_id,
                    'year_period'=>$year_period,
                    'month_period'=>$x+1,
                    'descriptions'=>$descriptions,
                    'start_date'=>$start_date,
                    'end_date'=>$end_date,
                    'enum_status'=>'Open',
                    'is_closed'=>'0',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
        }
        $data= FiscalYear::selectRaw("fiscal_id,year_period,month_period,descriptions,
            start_date,end_date,enum_status,is_closed,update_userid,update_timestamp")
            ->where("year_period",$year_period)
            ->get();
        return response()->success('success',$data);
    }

    public function post(Request $request)
    {
        $data= $request->json()->all();
        $rows=$data['data'];
        DB::beginTransaction();
        try{
            foreach($rows as $row) {
                $row['enum_status'] =  ($row['is_closed']=='0') ? "Open" :"Closed";
                FiscalYear::where('fiscal_id',$row['fiscal_id'])
                ->update([
                    'year_period'=>$row['year_period'],
                    'month_period'=>$row['month_period'],
                    'descriptions'=>$row['descriptions'],
                    'start_date'=>$row['start_date'],
                    'end_date'=>$row['end_date'],
                    'enum_status'=>$row['enum_status'],
                    'is_closed'=>$row['is_closed'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'FiscalYear',-1,'','Fiscalyear ');
            DB::commit();
            $message='Simpan data berhasil';
            return response()->success('success',$message);
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }
}