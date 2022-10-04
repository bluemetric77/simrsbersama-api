<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=Warehouse::selectRaw("warehouse_id,descriptions,is_allow_negatif,is_allow_receive,
            is_allow_transfer,is_auto_transfer,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('warehouse_id', 'like', $filter);
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
        $warehouse_id=isset($request->warehouse_id) ? $request->warehouse_id :'XXXXX';
        $data=Warehouse::find($warehouse_id);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $warehouse_id=isset($request->warehouse_id) ? $request->warehouse_id :'XXXXX';
        $data=Warehouse::selectRaw("warehouse_id,descriptions,is_allow_negatif,is_allow_receive,
                is_allow_transfer,is_auto_transfer,is_active")
            ->where('warehouse_id',$warehouse_id)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'warehouse_id'=>'bail|required',
            'descriptions'=>'bail|required',
        ],[
            'warehouse_id.required'=>'Kode gudang harus diisi',
            'descriptions.required'=>'Nama gudang harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=Warehouse::find($row['warehouse_id']);
            if ($data){
                $data->update([
                    'warehouse_id'=>$row['warehouse_id'],
                    'descriptions'=>$row['descriptions'],
                    'is_allow_negatif'=>$row['is_allow_negatif'],
                    'is_allow_receive'=>$row['is_allow_receive'],
                    'is_allow_transfer'=>$row['is_allow_transfer'],
                    'is_auto_transfer'=>$row['is_auto_transfer'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                Warehouse::insert([
                    'warehouse_id'=>$row['warehouse_id'],
                    'descriptions'=>$row['descriptions'],
                    'is_allow_negatif'=>$row['is_allow_negatif'],
                    'is_allow_receive'=>$row['is_allow_receive'],
                    'is_allow_transfer'=>$row['is_allow_transfer'],
                    'is_auto_transfer'=>$row['is_auto_transfer'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Warehouse',-1,$row['warehouse_id'],'Gudang '.$row['warehouse_id'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=Warehouse::selectRaw("warehouse_id,descriptions as warehouse_name")
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }
}
