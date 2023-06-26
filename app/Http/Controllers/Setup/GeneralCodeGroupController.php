<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setup\StandardGroupCode;

class GeneralCodeGroupController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $parent_id = isset($request->parent_id) ? $request->parent_id :'-1';
        $data=StandardGroupCode::from('m_standard_code_group as a')
        ->selectRaw("a.sysid,a.parent_code,a.descriptions,a.module,a.uuid_rec");
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('a.parent_code', 'like', $filter);
                $q->orwhere('a.descriptions', 'like', $filter);
            });
        }
        $data = $data->orderBy('a.'.$sortBy, ($descending) ? 'desc':'asc')->paginate($limit);
        return response()->success('Success', $data);
    }

    public function destroy(Request $request){
        $uuidrec=isset($request->uuidrec) ? $request->uuidrec :'N/A';
        $data=StandardGroupCode::where('uuid_rec',$uuidrec)->first();
        if ($data) {
            DB::beginTransaction();
            try{
                PagesHelp::write_log($request,$data->sysid,$data->parent_code,'Deleting records');
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
        $data=StandardGroupCode::from('m_standard_code_group as a')
        ->selectRaw("a.sysid,a.parent_code,a.descriptions,a.module,a.uuid_rec")
        ->where('a.uuid_rec',$uuidrec)->first();
        return response()->success('Success',$data);
    }

    public function store(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'parent_code'=>'bail|required',
            'descriptions'=>'bail|required',
        ],[
            'parent_code.required'=>'Kode harus diisi',
            'descriptions.required'=>'keterangan kode diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            if ($opr=='inserted'){
                $data = new StandardGroupCode();
                $data->uuid_rec=Str::uuid();
                $data->create_by=PagesHelp::Users($request)->sysid;                
            } else if ($opr=='updated'){
                $data = StandardGroupCode::where('uuid_rec',$row['uuid_rec'])->first();
                $data->update_by=PagesHelp::Users($request)->sysid;
            }
            $data->parent_code=$row['parent_code'];
            $data->descriptions=$row['descriptions'];
            $data->value=$row['value'];
            $data->save();
            PagesHelp::write_log($request,$data->sysid,$data->parent_code,'Add/Update recods');
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }

}
