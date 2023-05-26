<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Setup\StandardCode;
use App\Models\Setup\StandardGroupCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use PagesHelp;


class GeneralCodeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $parent_id = isset($request->parent_id) ? $request->parent_id :'-1';
        $data=StandardCode::from('m_standard_code as a')
        ->selectRaw("a.sysid,a.standard_code,a.descriptions,a.parent_id,a.is_active,a.update_date,a.create_date,
        a.uuid_rec,c.full_name as create_by,d.full_name as update_by")
        ->leftjoin('m_standard_code_group as b','a.parent_id','=','b.sysid')
        ->leftjoin('o_users as c','a.create_by','=','c.sysid')
        ->leftjoin('o_users as d','a.update_by','=','d.sysid')
        ->where('a.parent_id',$parent_id);

        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.standard_code', 'like', $filter);
                $q->orwhere('a.descriptions', 'like', $filter);
            });
        }
        $data = $data->orderBy('a.'.$sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'N/A';
        $data=StandardCode::where('uuid_rec',$uuidrec)->first();
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->standard_code,'Deleting records');
                $data->delete();
                DB::commit();
                return response()->success('Success','Hapus data berhasil');
            } 
            catch(\Exception $e) {
                DB::rollback();
                return response()->error('',501,$e);
            }
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function edit(Request $request){
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'N/A';
        $data=StandardCode::from('m_standard_code as a')
        ->selectRaw("a.sysid,a.standard_code,a.descriptions,a.parent_id,a.is_active,a.update_date,a.create_date,
        a.uuid_rec,b.parent_code,b.descriptions as parent_name")
        ->leftjoin('m_standard_code_group as b','a.parent_id','=','b.sysid')
        ->where('a.uuid_rec',$uuidrec)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $opr = $info['operation'];
        $validator=Validator::make($row,
        [
            'standard_code'=>'bail|required',
            'descriptions'=>'bail|required',
            'parent_id'=>'bail|required',
        ],[
            'standard_code.required'=>'Kode harus diisi',
            'descriptions.required'=>'keterangan kode diisi',
            'parent_id.required'=>'Group kode harus diisi'
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new StandardCode();
                $data->parent_id=$row['parent_id'];
                $data->create_by=PagesHelp::Users($request)->sysid;                
            } else if ($opr=='updated'){
                $data = StandardCode::where('uuid_rec',$row['uuid_rec'])->first();
                $data->update_by=PagesHelp::Users($request)->sysid;
            }
            $data->uuid_rec=Str::uuid();
            $data->standard_code=$row['standard_code'];
            $data->descriptions=$row['descriptions'];
            $data->is_active=isset($row['is_active']) ? $row['is_active'] :'1';
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->standard_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
}
