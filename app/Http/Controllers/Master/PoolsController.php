<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Pools;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;

class PoolsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $data=Pools::selectRaw("pool_code,pool_code,descriptions,project_code,warehouse_code,cash_intransit,is_active,update_userid,update_timestamp");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('pool_code', 'like', $filter);
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
        $pool_code=isset($request->pool_code) ? $request->pool_code :'-1';
        $data=Pools::find($pool_code);
        if ($data) {
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tpool_codeak ditemukan');
        }
    }

    public function get(Request $request){
        $pool_code=isset($request->pool_code) ? $request->pool_code :'-1';
        $data=Pools::selectRaw("pool_code,pool_code,descriptions,project_code,warehouse_code,cash_intransit,is_active")
            ->where('pool_code',$pool_code)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $valpool_codeator=Validator::make($row,
        [
            'pool_code'=>'bail|required',
            'descriptions'=>'bail|required',
        ],[
            'pool_code.required'=>'Kode pool harus diisi',
            'descriptions.required'=>'Nama pool harus diisi',
        ]);
        if ($valpool_codeator->fails()) {
            return response()->error('',501,$valpool_codeator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=Pools::find($row['old_pool_code']);
            if ($data){
                $data->update([
                    'pool_code'=>$row['pool_code'],
                    'descriptions'=>$row['descriptions'],
                    'project_code'=>$row['project_code'],
                    'warehouse_code'=>$row['warehouse_code'],
                    'cash_intransit'=>$row['cash_intransit'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            } else {
                Pools::insert([
                    'pool_code'=>$row['pool_code'],
                    'descriptions'=>$row['descriptions'],
                    'project_code'=>$row['project_code'],
                    'warehouse_code'=>$row['warehouse_code'],
                    'cash_intransit'=>$row['cash_intransit'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d h:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Pools',-1,$row['pool_code'],'Data Pool '.$row['pool_code'].'-'.$row['descriptions']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $all=isset($request->all) ? $request->all :'0';
        $rows=Pools::selectRaw("id,pool_code,descriptions as pool_name")
            ->where('is_active','1')
            ->orderBy('descriptions','asc')->get();
        $data=array();
        if ($all=='1'){
            $line['id']=-1;
            $line['pool_code']='ALL';
            $line['pool_name']='SEMUA POOL';
            $data[]=$line;    
        }
        foreach($rows as $row){
           $data[]=$row; 
        }
        return response()->success('Success',$data);
    }
}
