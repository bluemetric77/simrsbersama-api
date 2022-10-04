<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\ItemGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class ItemGroupController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=ItemGroup::selectRaw("item_group,descriptions,account_no,expense_account,variant_account,cogs_account,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('item_group', 'like', $filter);
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
        $item_group=isset($request->item_group) ? $request->item_group :'XXXXX';
        $data=ItemGroup::find($item_group);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $item_group=isset($request->item_group) ? $request->item_group :'XXXXX';
        $data=ItemGroup::selectRaw("item_group,descriptions,account_no,expense_account,variant_account,cogs_account")
            ->where('item_group',$item_group)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'item_group'=>'bail|required',
            'descriptions'=>'bail|required',
            'account_no'=>'bail|required',
            'expense_account'=>'bail|required'
        ],[
            'item_group.required'=>'Kode group harus diisi',
            'descriptions.required'=>'Grup inventory harus diisi',
            'account_no.required'=>'Akun inventory harus diisi',
            'expense_account.required'=>'Akun biaya inventory harus diisi'
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=ItemGroup::find($row['item_group']);
            if ($data){
                $data->update([
                    'item_group'=>$row['item_group'],
                    'descriptions'=>$row['descriptions'],
                    'account_no'=>$row['account_no'],
                    'expense_account'=>$row['expense_account'],
                    'variant_account'=>$row['variant_account'],
                    'cogs_account'=>$row['cogs_account'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                ItemGroup::insert([
                    'item_group'=>$row['item_group'],
                    'descriptions'=>$row['descriptions'],
                    'account_no'=>$row['account_no'],
                    'expense_account'=>$row['expense_account'],
                    'variant_account'=>$row['variant_account'],
                    'cogs_account'=>$row['cogs_account'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'ItemGroup',-1,$row['item_group'],'Item group '.$row['item_group'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=ItemGroup::selectRaw("item_group,descriptions as item_group_name")
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }
}
