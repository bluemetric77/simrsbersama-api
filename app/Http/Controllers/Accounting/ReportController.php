<?php

namespace App\Http\Controllers\Accounting;

use App\Models\Accounting\Journal1;
use App\Models\Accounting\Journal2;
use App\Models\Master\COA;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PagesHelp;
use Accounting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class ReportController extends Controller
{    
      public function bs_standart(Request $request){
        $month=$request->month;
        $year=$request->year;
        $type=isset($request->type) ? $request->type :'report';
        $detail=isset($request->detail) ? $request->detail :'1';
        DB::table('m_account')->update(['reversed1'=>0]);
        if ($detail=='0'){
            $activa=Account::selectRaw('account_no,account_name,reversed1,account_header,level_account')
            ->where('account_group','=','1')
            ->where('is_header','=','1')->get();
            $activa->makeVisible(['reversed1']);

            $passiva=Account::selectRaw('account_no,account_name,reversed1,account_header,level_account')
            ->where('is_header','=','1')
            ->where(function($q) {
                  $q->where('account_group', '2')
                  ->orWhere('account_group', '3');
                  })
            ->get();
            $passiva->makeVisible(['reversed1']);
            $idx=-1;
            foreach($activa as $line){
                  $idx++;
                  $field_debit='a.debit_month'.strval($month);
                  $field_credit='a.credit_month'.strval($month);
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("b.account_header,SUM(IFNULL($field_debit,0) - IFNULL($field_credit,0)) as mutasi")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('b.account_header',$line->account_no)
                        ->groupBy('b.account_header')->first();
                  if ($data){
                        $activa[$idx]['reversed1']=$data->mutasi;
                  }
            }
            $idx=-1;
            foreach($passiva as $line){
                  $idx++;
                  $field_debit='a.debit_month'.strval($month);
                  $field_credit='a.credit_month'.strval($month);
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("b.account_header,SUM(IFNULL($field_credit,0) - IFNULL($field_debit,0)) as mutasi")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('b.account_header',$line->account_no)
                        ->groupBy('b.account_header')->first();
                  if ($data){
                        $passiva[$idx]['reversed1']=$data->mutasi;
                  }
            }        
        } else {
            $activa=Account::selectRaw('account_no,account_name,reversed1,account_header,level_account')
            ->where('account_group','1')->get();
            $activa->makeVisible(['reversed1']);

            $passiva=Account::selectRaw('account_no,account_name,reversed1,account_header,level_account')
            ->where(function($q) {
                  $q->where('account_group', '2')
                  ->orWhere('account_group', '3');
                  })
            ->get();
            $passiva->makeVisible(['reversed1']);
            $idx=-1;
            foreach($activa as $line){
                  $idx++;
                  $field_debit='a.debit_month'.strval($month);
                  $field_credit='a.credit_month'.strval($month);
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("a.no_account,SUM(IFNULL($field_debit,0) - IFNULL($field_credit,0)) as mutasi")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('a.no_account',$line->account_no)
                        ->groupBy('a.no_account')->first();
                  if ($data){
                        $activa[$idx]['reversed1']=$data->mutasi;
                  }
            }
            $idx=-1;
            foreach($passiva as $line){
                  $idx++;
                  $field_debit='a.debit_month'.strval($month);
                  $field_credit='a.credit_month'.strval($month);
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("a.no_account,SUM(IFNULL($field_credit,0) - IFNULL($field_debit,0)) as mutasi")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('a.no_account',$line->account_no)
                        ->groupBy('a.no_account')->first();
                  if ($data){
                        $passiva[$idx]['reversed1']=$data->mutasi;
                  }
            }        
        }
        $header['title']='NERACA STANDAR';
        $header['period']=PagesHelp::month($month)." ".$year;
        $title = ['title' => 'Laporan Balance Sheet Standar '];
        if ($type=='report'){
            if ($detail=='0') {
               $view='accounting.balancesheet1';
            } else {
               $view='accounting.balancesheet1_detail';
            } 
            $pdf = PDF::loadView($view,['header'=>$header,'activa'=>$activa,'passiva'=>$passiva])->setPaper('a4','landscape');
            return $pdf->stream();
        }
      }

      public function bs_period(Request $request){
        $month=$request->month;
        $year=$request->year;
        $type=isset($request->type) ? $request->type :'report';
        $detail=isset($request->detail) ? $request->detail :'1';
        DB::table('m_account')->update(['reversed1'=>0,'reversed2'=>'0']);
        if ($detail=='0'){
            $activa=Account::selectRaw('account_no,account_name,reversed1,reversed2,account_header,level_account')
            ->where('account_group','=','1')
            ->where('is_header','=','1')->get();
            $activa->makeVisible(['reversed1','reversed2']);

            $passiva=Account::selectRaw('account_no,account_name,reversed1,reversed2,account_header,level_account')
            ->where('is_header','=','1')
            ->where(function($q) {
                  $q->where('account_group', '2')
                  ->orWhere('account_group', '3');
                  })
            ->get();
            $passiva->makeVisible(['reversed1','reversed2']);
            $idx=-1;
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            $summary='';
            for ($i=1;$i<=intval($month);$i++){
                  $debit='a.debit_month'.strval($i);
                  $credit='a.credit_month'.strval($i);
                  $summary=$summary."+(IFNULL($debit,0)-IFNULL($credit,0))";       
            }
            $summary="IFNULL(a.begining_balance,0)".$summary;
            foreach($activa as $line){
                  $idx++;
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("b.account_header,SUM(IFNULL($field_debit,0) - IFNULL($field_credit,0)) as mutasi,SUM($summary) as mutasi2")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('b.account_header',$line->account_no)
                        ->groupBy('b.account_header')->first();
                  if ($data){
                        $activa[$idx]['reversed1']=$data->mutasi;
                        $activa[$idx]['reversed2']=$data->mutasi2;
                  }
            }
            $idx=-1;
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            $summary='';
            for ($i=1;$i<=intval($month);$i++){
                  $debit='a.debit_month'.strval($i);
                  $credit='a.credit_month'.strval($i);
                  $summary=$summary."+(IFNULL($credit,0)-IFNULL($debit,0))";       
            }
            $summary="IFNULL(a.begining_balance,0)".$summary;
            foreach($passiva as $line){
                  $idx++;
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("b.account_header,SUM(IFNULL($field_credit,0) - IFNULL($field_debit,0)) as mutasi,SUM($summary) as mutasi2")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('b.account_header',$line->account_no)
                        ->groupBy('b.account_header')->first();
                  if ($data){
                        $passiva[$idx]['reversed1']=$data->mutasi;
                        $passiva[$idx]['reversed2']=$data->mutasi2;
                  }
            }        
        } else {
            $activa=Account::selectRaw('account_no,account_name,reversed1,reversed2,account_header,level_account')
            ->where('account_group','1')->get();
            $activa->makeVisible(['reversed1','reversed2']);

            $passiva=Account::selectRaw('account_no,account_name,reversed1,reversed2,account_header,level_account')
            ->where(function($q) {
                  $q->where('account_group', '2')
                  ->orWhere('account_group', '3');
                  })
            ->get();
            $passiva->makeVisible(['reversed1','reversed2']);

            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            $summary='';
            for ($i=1;$i<=intval($month);$i++){
                  $debit='a.debit_month'.strval($i);
                  $credit='a.credit_month'.strval($i);
                  $summary=$summary."+(IFNULL($debit,0)-IFNULL($credit,0))";       
            }
            $summary="IFNULL(a.begining_balance,0)".$summary;
            $idx=-1;
            foreach($activa as $line){
                  $idx++;
                  $field_debit='a.debit_month'.strval($month);
                  $field_credit='a.credit_month'.strval($month);
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("a.no_account,SUM(IFNULL($field_debit,0) - IFNULL($field_credit,0)) as mutasi,SUM($summary) as mutasi2")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('a.no_account',$line->account_no)
                        ->groupBy('a.no_account')->first();
                  if ($data){
                        $activa[$idx]['reversed1']=$data->mutasi;
                        $activa[$idx]['reversed2']=$data->mutasi2;
                  }
            }
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            $summary='';
            for ($i=1;$i<=intval($month);$i++){
                  $debit='a.debit_month'.strval($i);
                  $credit='a.credit_month'.strval($i);
                  $summary=$summary."+(IFNULL($credit,0)-IFNULL($debit,0))";       
            }
            $summary="IFNULL(a.begining_balance,0)".$summary;
            $idx=-1;
            foreach($passiva as $line){
                  $idx++;
                  $field_debit='a.debit_month'.strval($month);
                  $field_credit='a.credit_month'.strval($month);
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("a.no_account,SUM(IFNULL($field_credit,0) - IFNULL($field_debit,0)) as mutasi,SUM($summary) as mutasi2")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('a.no_account',$line->account_no)
                        ->groupBy('a.no_account')->first();
                  if ($data){
                        $passiva[$idx]['reversed1']=$data->mutasi;
                        $passiva[$idx]['reversed2']=$data->mutasi2;
                  }
            }        
        }
        $header['title']='NERACA PER PERIODE';
        $header['period']=PagesHelp::month($month)." ".$year;
        $title = ['title' => 'Laporan Balance Sheet Standar '];
        if ($type=='report'){
            if ($detail=='0') {
               $view='accounting.balancesheetperiod';
            } else {
               $view='accounting.balancesheetperiod_detail';
            } 
            $pdf = PDF::loadView($view,['header'=>$header,'activa'=>$activa,'passiva'=>$passiva])->setPaper('a4','landscape');
            return $pdf->stream();
        }
      }

      public function pl_standart(Request $request){
        $month=$request->month;
        $year=$request->year;
        $type=isset($request->type) ? $request->type :'report';
        $detail=isset($request->detail) ? $request->detail :'1';
        $project=isset($request->project) ? $request->project :'00';
        DB::table('m_account')->update(['reversed1'=>0,'reversed2'=>'0']);
        if ($detail=='0') {
            $profitloss=Account::selectRaw('account_no,account_name,reversed1,reversed2,account_header,level_account,enum_drcr')
            ->where('account_group','>','3')
            ->where('is_header','=','1')->orderBy('account_no')->get();
            $profitloss->makeVisible(['reversed1','reversed2']);
            $idx=-1;
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            foreach($profitloss as $line){
                  $idx++;
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("($field_credit - $field_debit) as mutasi")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('b.account_header',$line->account_no)->first();
                  if ($data){
                      $profitloss[$idx]['reversed1']=$data->mutasi;
                  }
            }
        } else {
            $profitloss=Account::selectRaw("account_no,account_name,reversed1,account_header,level_account,IFNULL(enum_drcr,'') as enum_drcr")
            ->where('account_group','>','3')
            ->orderBy('account_no')->get();
            $profitloss->makeVisible(['reversed1','reversed2']);
            $idx=-1;
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            foreach($profitloss as $line){
                  $idx++;
                  if ($line->enum_drcr=='D'){
                      $data=DB::table('t_account_mutation as a')->selectRaw("a.no_account,SUM($field_debit - $field_credit) as mutasi");
                  } else {
                      $data=DB::table('t_account_mutation as a')->selectRaw("a.no_account,SUM($field_credit - $field_debit) as mutasi");
                  }            
                  $data=$data->where('a.fiscal_year',$year)->where('a.no_account',$line->account_no);
                  if ($project=='00') {     
                        $data=$data->groupBy('a.no_account')->first();
                  } else {
                        $data=$data->where('a.project',$project)
                        ->groupBy('a.no_account')->first();
                  }

                  if ($data){
                      $profitloss[$idx]['reversed1']=$data->mutasi;
                  }
            }
        }
        $header['title']='LABA/RUGI STANDAR';
        $header['period']=PagesHelp::month($month)." ".$year;
        $title = ['title' => 'Laporan Laba/Rugi Standar '];

        if ($type=='report'){
            if ($detail=='0') {
               $pdf = PDF::loadView('accounting.pl_standart',['header'=>$header,'profitloss'=>$profitloss])->setPaper('a4','landscape');
            } else {
               $pdf = PDF::loadView('accounting.pl_standart_detail',['header'=>$header,'profitloss'=>$profitloss])->setPaper('a4','landscape');
            }
            return $pdf->stream();
        }
      }
    
      public function pl_period(Request $request){
        $month=$request->month;
        $year=$request->year;
        $type=isset($request->type) ? $request->type :'report';
        $detail=isset($request->detail) ? $request->detail :'1';
        $project=isset($request->project) ? $request->project :'00';
        DB::table('m_account')->update(['reversed1'=>0,'reversed2'=>'0']);
        if ($detail=='0') {
            $profitloss=Account::selectRaw('account_no,account_name,reversed1,account_header,level_account,enum_drcr')
            ->where('account_group','>','3')
            ->where('is_header','=','1')->orderBy('account_no')->get();
            $idx=-1;
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            foreach($profitloss as $line){
                  $idx++;
                  $data=DB::table('t_account_mutation as a')
                        ->selectRaw("($field_credit - $field_debit) as mutasi")
                        ->join("m_account as b",'a.no_account','=','b.account_no')
                        ->where('a.fiscal_year',$year)
                        ->where('b.account_header',$line->account_no)->first();
                  if ($data){
                      $profitloss[$idx]['reversed1']=$data->mutasi;
                  }
            }
        } else {
            $profitloss=Account::selectRaw("account_no,account_name,reversed1,reversed2,account_header,level_account,IFNULL(enum_drcr,'') as enum_drcr")
            ->where('account_group','>','3')
            ->orderBy('account_no')->get();
            $profitloss->makeVisible(['reversed1','reversed2']);
            $idx=-1;
            $field_debit='a.debit_month'.strval($month);
            $field_credit='a.credit_month'.strval($month);
            foreach($profitloss as $line){
                  $summary='';
                  for ($i=1;$i<=intval($month);$i++){
                        $debit='a.debit_month'.strval($i);
                        $credit='a.credit_month'.strval($i);
                        if ($line->enum_drcr=='D'){
                              $summary=$summary."+(IFNULL($debit,0)-IFNULL($credit,0))";       
                        } else {
                              $summary=$summary."+(IFNULL($credit,0)-IFNULL($debit,0))";       
                        }
                  }
                  $summary="IFNULL(a.begining_balance,0)".$summary;
                  $idx++;
                  if ($line->enum_drcr=='D'){
                      $data=DB::table('t_account_mutation as a')
                      ->selectRaw("a.no_account,SUM($field_debit - $field_credit) as mutasi,SUM($summary) as mutasi2");
                  } else {
                      $data=DB::table('t_account_mutation as a')
                      ->selectRaw("a.no_account,SUM($field_credit - $field_debit) as mutasi,SUM($summary) as mutasi2");
                  }            
                  $data=$data->where('a.fiscal_year',$year)->where('a.no_account',$line->account_no);
                  if ($project=='00') {     
                        $data=$data->groupBy('a.no_account')->first();
                  } else {
                        $data=$data->where('a.project',$project)
                        ->groupBy('a.no_account')->first();
                  }
                  if ($data){
                      $profitloss[$idx]['reversed1']=$data->mutasi;
                      $profitloss[$idx]['reversed2']=$data->mutasi2;
                  }
            }
        }
        $header['title']='LABA/RUGI STANDAR';
        $header['period']=PagesHelp::month($month)." ".$year;
        $title = ['title' => 'Laporan Laba/Rugi Periode '];

        if ($type=='report'){
            if ($detail=='0') {
               $pdf = PDF::loadView('accounting.pl_period',['header'=>$header,'profitloss'=>$profitloss])->setPaper('a4','landscape');
            } else {
               $pdf = PDF::loadView('accounting.pl_period_detail',['header'=>$header,'profitloss'=>$profitloss])->setPaper('a4','landscape');
            }
            return $pdf->stream();
        }
      }
}