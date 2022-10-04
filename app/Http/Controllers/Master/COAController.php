<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\COA;
use PagesHelp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class COAController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = ($request->descending=="true");
        $sortBy = $request->sortBy;
        $account_group=isset($request->account_group) ? $request->account_group :"1";
        $data= COA::selectRaw("account_no,account_name,account_header,account_group,level_account,
        is_header,enum_drcr,IFNULL(is_cash_bank,0) as is_cash_bank,is_posted,is_active,
        IFNULL(voucher_in,'') as voucher_in,IFNULL(voucher_out,'') as voucher_out,update_userid,update_timestamp")
        ->where("account_group",$account_group);
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where(function($q) use ($filter) {
                    $q->where('account_no','like',$filter)
                    ->orwhere('account_name','like',$filter);
            });
        }
        if ($descending) {
            $data=$data->orderBy($sortBy,'desc')->paginate($limit);
        } else {
            $data=$data->orderBy($sortBy,'asc')->paginate($limit);
        }
        return response()->success('Success',$data);
    }

    public function get(Request $request)
    {
        $account_no=$request->account_no;
        $data= COA::selectRaw("account_no,account_name,account_header,account_group,level_account,
        is_header,enum_drcr,IFNULL(is_cash_bank,0) as is_cash_bank,is_posted,is_active,
        IFNULL(voucher_in,'') as voucher_in,IFNULL(voucher_out,'') as voucher_out")
        ->where('account_no',$account_no)->first();
        return response()->success('success',$data);
    }

    public function delete(Request $request)
    {
        $account_no=$request->account_no;
        $data= COA::find($account_no);
        if ($data) {
            $data->delete();
            return response()->success('success','Hapus data berhasil');
        } else {
            return response()->error('',1001,"data tidak ditemukan");
        }
    }

    public function post(Request $request)
    {
        $data= $request->json()->all();
        $row=$data['data'];
        $validator=Validator::make($row,[
            'account_no'=>'bail|required',
            'account_name'=>'bail|required',
        ],[
            'account_no.required'=>'Nomor akun diisi',
            'account_name.required'=>'Nama akun perkiraan harus diisi',
        ]);

        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $data=COA::find($row['old_account_no']);
            $level=1;
            $header=COA::select("level_account")->where("account_no",$row['account_header'])->first();
            if ($header){
                $level=intval($header->level_account)+1;
            }
            if ($data){
                $data->update([
                    'account_no'=>$row['account_no'],
                    'account_name'=>$row['account_name'],
                    'account_header'=>$row['account_header'],
                    'account_group'=>$row['account_group'],
                    'level_account'=>$level,
                    'is_header'=>$row['is_header'],
                    'enum_drcr'=>$row['enum_drcr'],
                    'is_cash_bank'=>$row['is_cash_bank'],
                    'is_posted'=>$row['is_posted'],
                    'is_active'=>$row['is_active'],
                    'mandatory_division'=>'0',
                    'mandatory_unit'=>'0',
                    'is_controlaccount'=>'0',
                    'voucher_in'=>$row['voucher_in'],
                    'voucher_out'=>$row['voucher_out'],
                    'update_timestamp'=>Date('Y-m-d h:i:s'),
                    'update_userid'=>PagesHelp::UserID($request)
                ]);
            } else {
                COA::insert([
                    'account_no'=>$row['account_no'],
                    'account_name'=>$row['account_name'],
                    'account_header'=>$row['account_header'],
                    'account_group'=>$row['account_group'],
                    'level_account'=>$level,
                    'is_header'=>$row['is_header'],
                    'enum_drcr'=>$row['enum_drcr'],
                    'is_cash_bank'=>$row['is_cash_bank'],
                    'is_posted'=>$row['is_posted'],
                    'is_active'=>$row['is_active'],
                    'mandatory_division'=>'0',
                    'mandatory_unit'=>'0',
                    'is_controlaccount'=>'0',
                    'voucher_in'=>$row['voucher_in'],
                    'voucher_out'=>$row['voucher_out'],
                    'update_timestamp'=>Date('Y-m-d h:i:s'),
                    'update_userid'=>PagesHelp::UserID($request)
                ]);
            }
            PagesHelp::write_log($request,'COA',-1,$row['account_no'],'COA '.$row['account_no'].'-'.$row['account_name']);
            DB::commit();
            $message='Simpan data berhasil';
            return response()->success('success',$message);
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }
    public function getheader(Request $request){
        $account_group=isset($request->account_group) ? $request->account_group :'-1';
        $data=COA::selectRaw("account_no,CONCAT(account_no,' - ',account_name) as account_name")
            ->where("account_group",$account_group)
            ->orderBy("account_no","asc")->get();
        return response()->success('Success',$data);
    }

    public function coa(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = ($request->descending=="true");
        $sortBy = $request->sortBy;
        $data= COA::selectRaw("account_no,account_name,
        CASE IFNULL(account_group,'')
        WHEN '1' THEN 'AKTIVA'
        WHEN '2' THEN 'PASSIVA'
        WHEN '3' THEN 'MODAL'
        WHEN '4' THEN 'PENDAPATAN'
        WHEN '5' THEN 'BIAYA OPERASIONAL'
        WHEN '6' THEN 'BIAYA MARKETING'
        WHEN '7' THEN 'BIAYA PEGAWAI ADM & UMUM'
        WHEN '8' THEN 'PENDAPATAN & BIAYA LAIN-LAIN'
        WHEN '9' THEN 'PAJAK'
        ELSE '' END as clasification")
        ->where('is_posted','1')
        ->where('is_active','1');
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where(function($q) use ($filter) {
                    $q->where('account_no','like',$filter)
                    ->orwhere('account_name','like',$filter);
            });
        }
        if ($descending) {
            $data=$data->orderBy($sortBy,'desc')->paginate($limit);
        } else {
            $data=$data->orderBy($sortBy,'asc')->paginate($limit);
        }
        return response()->success('Success',$data);
    }
    public static function Getjurnaltype(){
        $data=DB::table('m_jurnal_type')->select('jurnal_type','descriptions')->get();
        return response()->success('Success',$data);
    }

}