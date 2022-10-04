<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Partner;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $enum = isset($request->enum) ? $request->enum :'';

        $data=Partner::selectRaw("partner_id,partner_name,partner_address, invoice_address,invoice_handler,phone_number,fax_number,email,
        contact_person,contact_phone,tax_number,partner_type,fee_of_storage,percent_of_storage,minimum_tonase,
        fee_of_tonase,due_interval,is_active,cash_id,format_id,ar_account,ap_account,dp_account,is_document,maximum_credit,
        update_userid,update_timestamp")
        ->where("partner_type",$enum);
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('partner_id', 'like', $filter);
                $q->orwhere('partner_name', 'like', $filter);
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
        $partner_id=isset($request->partner_id) ? $request->partner_id :'XXXXX';
        $data=Partner::find($partner_id);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $partner_id=isset($request->partner_id) ? $request->partner_id :'XXXXX';
        $data=Partner::selectRaw("partner_id,partner_name,partner_address, invoice_address,invoice_handler,phone_number,
        fax_number,email,maximum_credit,
        contact_person,contact_phone,tax_number,partner_type,fee_of_storage,percent_of_storage,minimum_tonase,
        fee_of_tonase,due_interval,is_active,cash_id,format_id,ar_account,ap_account,dp_account,is_document")
            ->where('partner_id',$partner_id)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'partner_id'=>'bail|required',
            'partner_name'=>'bail|required',
            'partner_address'=>'bail|required',
        ],[
            'partner_id.required'=>'Kode partner harus diisi',
            'partner_name.required'=>'Nama partner harus diisi',
            'partner_address.required'=>'Alamat harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=Partner::find($row['partner_id']);
            if ($data){
                $data->update([
                    'partner_id'=>$row['partner_id'],
                    'partner_name'=>$row['partner_name'],
                    'partner_address'=>$row['partner_address'],
                    'invoice_address'=>$row['invoice_address'],
                    'invoice_handler'=>$row['invoice_handler'],
                    'phone_number'=>$row['phone_number'],
                    'fax_number'=>$row['fax_number'],
                    'email'=>$row['email'],
                    'contact_person'=>$row['contact_person'],
                    'contact_phone'=>$row['contact_phone'],
                    'partner_type'=>$row['partner_type'],
                    'minimum_tonase'=>$row['minimum_tonase'],
                    'fee_of_tonase'=>$row['fee_of_tonase'],
                    'due_interval'=>$row['due_interval'],
                    'cash_id'=>$row['cash_id'],
                    'format_id'=>isset($row['format_id']) ? $row['format_id']:null,
                    'ar_account'=>$row['ar_account'],
                    'ap_account'=>$row['ap_account'],
                    'dp_account'=>$row['dp_account'],
                    'is_document'=>'0',
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                Partner::insert([
                    'partner_id'=>$row['partner_id'],
                    'partner_name'=>$row['partner_name'],
                    'partner_address'=>$row['partner_address'],
                    'invoice_address'=>$row['invoice_address'],
                    'invoice_handler'=>$row['invoice_handler'],
                    'phone_number'=>$row['phone_number'],
                    'fax_number'=>$row['fax_number'],
                    'email'=>$row['email'],
                    'contact_person'=>$row['contact_person'],
                    'contact_phone'=>$row['contact_phone'],
                    'partner_type'=>$row['partner_type'],
                    'minimum_tonase'=>$row['minimum_tonase'],
                    'fee_of_tonase'=>$row['fee_of_tonase'],
                    'due_interval'=>$row['due_interval'],
                    'cash_id'=>$row['cash_id'],
                    'format_id'=>isset($row['format_id']) ? $row['format_id']:null,
                    'ar_account'=>$row['ar_account'],
                    'ap_account'=>$row['ap_account'],
                    'dp_account'=>$row['dp_account'],
                    'is_document'=>'0',
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Partner',-1,$row['partner_id'],'Partner '.$row['partner_id'].'-'.$row['partner_name']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=Partner::selectRaw("partner_id,partner_name")
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }

    public function open(Request $request){
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $enum = isset($request->enum) ? $request->enum :'';

        $data=Partner::selectRaw("partner_id,partner_name,partner_address")
        ->where("partner_type",$enum)
        ->where("is_active",'1');
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('partner_id', 'like', $filter);
                $q->orwhere('partner_name', 'like', $filter);
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

}
