<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\VoucherJurnal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=VoucherJurnal::selectRaw("voucher_code,descriptions,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('voucher_code', 'like', $filter);
                $q->orwhere('descriptions', 'like', $filter);
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
        $voucher_code=isset($request->voucher_code) ? $request->voucher_code :'XXXXX';
        $data=VoucherJurnal::find($voucher_code);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $voucher_code=isset($request->voucher_code) ? $request->voucher_code :'XXXXX';
        $data=VoucherJurnal::selectRaw("voucher_code,descriptions,is_active")
            ->where('voucher_code',$voucher_code)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'voucher_code'=>'bail|required',
            'descriptions'=>'bail|required',
        ],[
            'voucher_code.required'=>'Kode group harus diisi',
            'descriptions.required'=>'Grup inventory harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=VoucherJurnal::find($row['old_voucher_code']);
            if ($data){
                $data->update([
                    'voucher_code'=>$row['voucher_code'],
                    'descriptions'=>$row['descriptions'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                VoucherJurnal::insert([
                    'voucher_code'=>$row['voucher_code'],
                    'descriptions'=>$row['descriptions'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Voucher Jurnal',-1,$row['voucher_code'],'Voucher jurnal '.$row['voucher_code'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=VoucherJurnal::selectRaw("voucher_code,CONCAT(voucher_code,' - ',descriptions) as voucher_name")
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }
}
