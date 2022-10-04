<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Items;
use App\Models\Master\Warehouse;
use App\Models\Master\ItemsStock;
use PagesHelp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = ($request->descending=="true");
        $sortBy = $request->sortBy;
        $data= Items::from('m_item as a')
        ->selectRaw("a.item_code,a.descriptions,a.part_number,a.descriptions,a.convertion,a.mou_purchase,
        a.mou_warehouse,a.item_group,b.descriptions as item_group_name,a.preferred_vendor,c.partner_name,
        a.last_purchase,a.last_transaction,a.is_hold,a.is_active,a.purchase_price,a.purchase_discount,
        a.purchase_tax,a.account_no,a.expense_account,a.cogs_account,a.variant_account,a.on_hand,
        a.update_timestamp,a.update_userid")
        ->leftjoin('m_item_group as b','a.item_group','=','b.item_group')
        ->leftjoin('m_partner as c','a.preferred_vendor','=','c.partner_id');
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where(function($q) use ($filter) {
                    $q->where('a.item_code','like',$filter)
                    ->orwhere('a.descriptions','like',$filter)
                    ->orwhere('a.part_number','like',$filter);
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
        $item_code=$request->item_code;
        $data= Items::from('m_item as a')
        ->selectRaw("a.item_code,a.descriptions,a.part_number,a.descriptions,a.convertion,a.mou_purchase,
        a.mou_warehouse,a.item_group,a.is_active,a.account_no,a.expense_account,a.cogs_account,a.variant_account")
        ->where('a.item_code',$item_code)->first();
        return response()->success('success',$data);
    }

    public function delete(Request $request)
    {
        $item_code=$request->item_code;
        $data= Items::find($item_code);
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
            'item_code'=>'bail|required',
            'part_number'=>'bail|required',
            'descriptions'=>'bail|required',
            'mou_purchase'=>'bail|required',
            'mou_warehouse'=>'bail|required',
            'convertion'=>'bail|required',
            'item_group'=>'bail|required',
        ],[
            'item_code.required'=>'Kode diisi',
            'part_number.required'=>'Nomor part harus diisi',
            'descriptions.required'=>'Nama item/inventory harus diisi',
            'mou_purchase.required'=>'Satuan beli harus diisi',
            'mou_warehouse.required'=>'Satuan simpan harus diisi',
            'convertion.required'=>'Konversi satuan beli harus diisi',
            'item_group.required'=>'Grup item harus diisi',
        ]);

        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }
        $row['apply_date']=null;

        DB::beginTransaction();
        try{
            $item_code=$row['item_code'];
            $data=Items::find($item_code);
            if ($data){
                $data->update([
                    'item_code'=>$row['item_code'],
                    'part_number'=>$row['part_number'],
                    'descriptions'=>$row['descriptions'],
                    'item_group'=>$row['item_group'],
                    'mou_purchase'=>$row['mou_purchase'],
                    'convertion'=>$row['convertion'],
                    'mou_warehouse'=>$row['mou_warehouse'],
                    'account_no'=>$row['account_no'],
                    'cogs_account'=>$row['cogs_account'],
                    'expense_account'=>$row['expense_account'],
                    'variant_account'=>$row['variant_account'],
                    'is_active'=>$row['is_active'],
                    'is_hold'=>'0',
                    'is_sale'=>'1',
                    'is_purchase'=>'1',
                    'is_stock_record'=>'1',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                Items::insert([
                    'item_code'=>$row['item_code'],
                    'part_number'=>$row['part_number'],
                    'descriptions'=>$row['descriptions'],
                    'item_group'=>$row['item_group'],
                    'mou_purchase'=>$row['mou_purchase'],
                    'convertion'=>$row['convertion'],
                    'mou_warehouse'=>$row['mou_warehouse'],
                    'account_no'=>$row['account_no'],
                    'cogs_account'=>$row['cogs_account'],
                    'expense_account'=>$row['expense_account'],
                    'variant_account'=>$row['variant_account'],
                    'is_active'=>$row['is_active'],
                    'is_hold'=>'0',
                    'is_sale'=>'1',
                    'is_purchase'=>'1',
                    'is_stock_record'=>'1',
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            $whs=Warehouse::selectRaw("warehouse_id")->get();
            foreach($whs as $wh) {
                if(!ItemsStock::where('warehouse_id',$wh->warehouse_id)
                    ->where('item_code',$row['item_code'])->exists()){
                    ItemsStock::insert([
                        'warehouse_id'=>$wh->warehouse_id,
                        'item_code'=>$row['item_code'],
                        'is_hold'=>'0',
                        'on_hand'=>0,
                        'on_demand'=>0,
                        'on_order'=>0,
                        'maximum_stock'=>0,
                        'minimum_stock'=>0,
                        'last_activity'=>Date('Y-m-d h:i:s'),
                        'stock_location'=>'-'
                    ]);
                }
            }
            PagesHelp::write_log($request,'Items',-1,$row['item_code'],'Item Code '.$row['item_code'].'-'.$row['descriptions']);
            DB::commit();
            $message='Simpan data berhasil';
            return response()->success('success',$message);
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }
    public function open(Request $request)
    {
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = ($request->descending=="true");
        $sortBy = $request->sortBy;
        $data= Items::from('m_items as a')
        ->selectRaw("a.item_code,a.part_number,a.descriptions,b.descriptions as item_group_name")
        ->leftjoin('m_item_group as b','a.item_group','=','b.item_group')
        ->where('a.is_active','1');
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where(function($q) use ($filter) {
                    $q->where('a.item_code','like',$filter)
                    ->orwhere('a.part_number','like',$filter)
                    ->orwhere('a.descriptions','like',$filter);
            });
        }
        if ($descending) {
            $data=$data->orderBy($sortBy,'desc')->paginate($limit);
        } else {
            $data=$data->orderBy($sortBy,'asc')->paginate($limit);
        }
        return response()->success('Success',$data);
    }
}