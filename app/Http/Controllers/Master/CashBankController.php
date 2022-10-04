<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\CashBank;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class CashBankController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=CashBank::selectRaw("cash_id,descriptions,bank_account,account_name,account_number,
            no_account,is_headoffice,is_usedinvoice,is_bank,is_operasional,voucher_in,voucher_out,
            voucher_ge,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('descriptions', 'like', $filter);
                $q->orwhere('bank_account', 'like', $filter);
                $q->orwhere('account_name', 'like', $filter);
                $q->orwhere('account_number', 'like', $filter);
            });
        }
        if (!($sortBy == '')) {
            if ($descending) {
                $data = $data->orderBy($sortBy, 'desc')->paginate($limit);
            } else {
                $data = $data->orderBy($sortBy, 'asc')->paginate($limit);
            }
        } else {
            $data = $data->paginate($limit);
        }
        return response()->success('Success', $data);
    }

    public function delete(Request $request){
        $cash_id=isset($request->cash_id) ? $request->cash_id :'-1';
        $data=CashBank::find($cash_id);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $cash_id=isset($request->cash_id) ? $request->cash_id :'-1';
        $data=CashBank::selectRaw("cash_id,descriptions,bank_account,account_name,account_number,
            no_account,is_headoffice,is_usedinvoice,is_bank,is_operasional,voucher_in,voucher_out,
            voucher_ge,is_active")
            ->where('cash_id',$cash_id)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'descriptions'=>'bail|required',
            'bank_account'=>'bail|required',
            'account_name'=>'bail|required',
            'account_number'=>'bail|required',
            'no_account'=>'bail|required',
        ],[
            'descriptions.required'=>'Nama Kas/Bank harus diisi',
            'bank_account.required'=>'Bank harus diisi',
            'account_name.required'=>'Nama rekening harus diisi',
            'account_number.required'=>'Nomor rekening harus diisi',
            'no_account.required'=>'Kode akun harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=CashBank::find($row['cash_id']);
            if ($data){
                $data->update([
                    'descriptions'=>$row['descriptions'],
                    'bank_account'=>$row['bank_account'],
                    'account_name'=>$row['account_name'],
                    'account_number'=>$row['account_number'],
                    'no_account'=>$row['no_account'],
                    'is_bank'=>$row['is_bank'],
                    'is_headoffice'=>$row['is_headoffice'],
                    'is_operasional'=>$row['is_operasional'],
                    'is_usedinvoice'=>$row['is_usedinvoice'],
                    'voucher_in'=>$row['voucher_in'],
                    'voucher_out'=>$row['voucher_out'],
                    'voucher_ge'=>$row['voucher_ge'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                $cash_id=CashBank::max('cash_id');
                $cash_id=intval($cash_id)+1;
                CashBank::insert([
                    'cash_id'=>$cash_id,
                    'descriptions'=>$row['descriptions'],
                    'bank_account'=>$row['bank_account'],
                    'account_name'=>$row['account_name'],
                    'account_number'=>$row['account_number'],
                    'no_account'=>$row['no_account'],
                    'is_bank'=>$row['is_bank'],
                    'is_headoffice'=>$row['is_headoffice'],
                    'is_operasional'=>$row['is_operasional'],
                    'is_usedinvoice'=>$row['is_usedinvoice'],
                    'voucher_in'=>$row['voucher_in'],
                    'voucher_out'=>$row['voucher_out'],
                    'voucher_ge'=>$row['voucher_ge'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Cash/Bank',-1,$row['cash_id'],'Kas/bank perusahaan '.$row['cash_id'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

    public function getlist(Request $request){
        $data=CashBank::selectRaw("cash_id,descriptions,account_name,account_number,
              IFNULL(voucher_in,'') voucher_in,IFNULL(voucher_out,'') voucher_out,IFNULL(voucher_ge,'') voucher_ge,is_headoffice")
            ->where('is_active','1')
            ->orderBy('cash_id','asc')->get();
        return response()->success('Success',$data);
    }
    public function getlistbyuser(Request $request){
        $userid=PagesHelp::UserID($request);
        $data=CashBank::from("m_cash_operation as a")->selectRaw("a.cash_id,a.descriptions,a.account_name,a.account_number,
              IFNULL(a.voucher_in,'') voucher_in,IFNULL(a.voucher_out,'') voucher_out,IFNULL(a.voucher_ge,'') voucher_ge")
            ->join("o_user_cashbank as b", function($join) use($userid){
                $join->on("a.cash_id","=","b.cash_id");
                $join->on("b.user_id","=",DB::raw("'$userid'"));
                $join->on("b.is_allow","=",DB::raw('1'));
            })  
            ->where('a.is_active','1')
            ->orderBy('a.cash_id','asc')->get();
        return response()->success('Success',$data);
    }

}
