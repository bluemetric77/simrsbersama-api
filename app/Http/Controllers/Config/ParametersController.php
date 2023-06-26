<?php

namespace App\Http\Controllers\Config;

use App\Models\Config\Parameters;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;
use Illuminate\Support\Str;

class ParametersController extends Controller
{
    public function show(Request $request){
        $filter = $request->filter;
        $limit = $request->limit;
        $descending = $request->descending=="true";
        $sortBy = $request->sortBy;
        $groups=isset($request->groups) ? $request->groups :'ALL';
        $data= Parameters::from('o_parameters as a')
        ->selectRaw("a.key_word,a.key_type,a.key_descriptions,a.key_decimal,a.key_value_integer,
        a.key_value_decimal,a.key_value_date,a.key_value_nvarchar,a.key_value_boolean,a.key_groups,
        a.key_ref,a.key_ref_value,a.update_by,a.update_date,b.full_name")
        ->leftjoin('o_users as b','a.update_by','=','b.sysid');
        if ($groups !='ALL') {
            $data=$data->where('key_groups',$groups);
        }
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where('a.key_word','like',$filter)
               ->orwhere('a.key_descriptions','like',$filter);
        }
        if ($descending) {
            $data=$data->orderBy($sortBy,'desc')->paginate($limit);
        } else {
            $data=$data->orderBy($sortBy,'asc')->paginate($limit);
        }
        return response()->success('Success',$data);
    }

    public function get(Request $request){
        $keyword=$request->keyword;
        $data=Parameters::where('key_word',$keyword)->first();
        return response()->success('Success',$data);
    }

    public function getgroup(Request $request) {
        $data=Parameters::selectRaw('key_groups')
        ->distinct()
        ->get();
        return response()->success('Success',$data);        
    }

    public function post(Request $request){
        $data= $request->json()->all();
        $rec=$data['data'];
        try{
            $param=Parameters::where('key_word',$rec['key_word'])->first();
            if ($param->key_type=='C') {
                $param->key_value_nvarchar=$rec['value'];
            } else if ($param->key_type=='I') {
                $param->key_value_integer=$rec['value'];
            } else if ($param->key_type=='N') {
                $param->key_value_decimal=$rec['value'];
            } else if ($param->key_type=='B') {
                $param->key_value_boolean=$rec['value'];
            } else if ($param->key_type=='D') {
                $param->key_value_date=$rec['value'];
            }
            
            $param->uuid_rec=Str::uuid();
            $param->update_by=PagesHelp::Users($request)->sysid;
            $param->update_date=Date('Y-m-d H:i:s');
            $param->save();
            return response()->success('Success','Simpan data Berhasil');
		} catch (\Execptions $e) {
            return response()->error('',501,$e);
        }
    }
}