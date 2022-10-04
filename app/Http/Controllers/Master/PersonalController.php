<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Personal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PagesHelp;
use Illuminate\Support\Facades\Storage;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $flagactive = isset($request->flagactive) ? $request->flagactive : '0';
        $data=Personal::selectRaw("personal_id,employee_id,personal_name,dob,personal_address,phone1,phone2,
                citizen_no,marital_state,driving_license_type,driving_license_no,driving_license_valid,
                personal_type,emergency_contact,emergency_phone,photo,ktp,
                bank_name,accont_number as account_number,account_name,pool_code,is_active,update_userid,update_timestamp");
        if ($flagactive=='1') {
            $data->where('is_active','1');
        }              
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('employee_id', 'like', $filter);
                $q->orwhere('personal_name', 'like', $filter);
                $q->orwhere('driving_license_no', 'like', $filter);
                $q->orwhere('citizen_no', 'like', $filter);
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
        $data=$data->toArray();
        $rows=array();
        $server=PagesHelp::my_server_url();
        foreach($data['data'] as $row){
            $row['photo_link']=$server.'/api/master/partner/driver/download?personal_id='.$row['personal_id']. '&document=photo';
            $rows[]=$row;
        }
        $data['data']=$rows;
        return response()->success('Success', $data);
    }

    public function delete(Request $request){
        $personal_id=isset($request->personal_id) ? $request->personal_id :'XXXXX';
        $data=Personal::find($personal_id);
        if ($data) {
            PagesHelp::write_log($request,'Driver',-1,$data->employee_id,'Driver '.$data->employee_id.'-'.$data->personal_name);
            $data->delete();
            return response()->success('Success','Hapus data berhasil');
        } else {
            return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function get(Request $request){
        $personal_id=isset($request->personal_id) ? $request->personal_id :'XXXXX';
        $data=Personal::selectRaw("personal_id,employee_id,personal_name,dob,personal_address,phone1,phone2,
                citizen_no,marital_state,driving_license_type,driving_license_no,driving_license_valid,
                personal_type,emergency_contact,emergency_phone,emergency_address,
                bank_name,accont_number as account_number,account_name,pool_code,is_active")
            ->where('personal_id',$personal_id)->first();
        return response()->success('Success',$data);
    }

    public function post(Request $request){
        $info = $request->json()->all();
        $row = $info['data'];
        $validator=Validator::make($row,
        [
            'employee_id'=>'bail|required',
            'personal_name'=>'bail|required',
            'personal_address'=>'bail|required',
            'citizen_no'=>'bail|required',
            'driving_license_no'=>'bail|required',
            'driving_license_valid'=>'bail|required',
            'emergency_contact'=>'bail|required',
            'emergency_phone'=>'bail|required',
        ],[
            'employee_id.required'=>'Kode partner harus diisi',
            'personal_name.required'=>'Nama partner harus diisi',
            'personal_address.required'=>'Alamat harus diisi',
            'citizen_no.required'=>'No KTP harus diisi',
            'driving_license_no.required'=>'No. SIM harus diisi',
            'driving_license_valid.required'=>'Masa berlaku SIM harus diisi',
            'emergency_contact.required'=>'Kontak darurat harus diisi',
            'emergency_phone.required'=>'Telepom kontak darurat harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $data=Personal::find($row['personal_id']);
            unset($row['personal_id']);
            if ($data){
                $data->update([
                    'employee_id'=>$row['employee_id'],
                    'personal_name'=>$row['personal_name'],
                    'dob'=>$row['dob'],
                    'personal_address'=>$row['personal_address'],
                    'phone1'=>$row['phone1'],
                    'phone2'=>$row['phone2'],
                    'citizen_no'=>$row['citizen_no'],
                    'marital_state'=>$row['marital_state'],
                    'driving_license_type'=>$row['driving_license_type'],
                    'driving_license_no'=>$row['driving_license_no'],
                    'driving_license_valid'=>$row['driving_license_valid'],
                    'personal_type'=>$row['personal_type'],
                    'emergency_contact'=>$row['emergency_contact'],
                    'emergency_address'=>isset($row['emergency_address']) ? $row['emergency_address'] :'',
                    'emergency_phone'=>$row['emergency_phone'],
                    'bank_name'=>$row['bank_name'],
                    'accont_number'=>$row['account_number'],
                    'account_name'=>$row['account_name'],
                    'pool_code'=>$row['pool_code'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            } else {
                if (Personal::where('citizen_no',$row['citizen_no'])->exists()) {
                    return response()->error('',501,'Nomor KTP tersebut sudah ada');
                    DB::rollback();    
                }
                Personal::insert([
                    'employee_id'=>$row['employee_id'],
                    'personal_name'=>$row['personal_name'],
                    'dob'=>$row['dob'],
                    'personal_address'=>$row['personal_address'],
                    'phone1'=>$row['phone1'],
                    'phone2'=>$row['phone2'],
                    'citizen_no'=>$row['citizen_no'],
                    'marital_state'=>$row['marital_state'],
                    'driving_license_type'=>$row['driving_license_type'],
                    'driving_license_no'=>$row['driving_license_no'],
                    'driving_license_valid'=>$row['driving_license_valid'],
                    'personal_type'=>$row['personal_type'],
                    'emergency_contact'=>$row['emergency_contact'],
                    'emergency_address'=>isset($row['emergency_address']) ? $row['emergency_address'] :'',
                    'emergency_phone'=>$row['emergency_phone'],
                    'bank_name'=>$row['bank_name'],
                    'accont_number'=>$row['account_number'],
                    'account_name'=>$row['account_name'],
                    'pool_code'=>$row['pool_code'],
                    'is_active'=>$row['is_active'],
                    'update_userid'=>PagesHelp::UserID($request),
                    'update_timestamp'=>Date('Y-m-d H:i:s')
                ]);
            }
            PagesHelp::write_log($request,'Driver',-1,$row['employee_id'],'Driver '.$row['employee_id'].'-'.$row['personal_name']);
            DB::commit();
            return response()->success('Success','Simpan data berhasil');
        } catch(Exception $error) {
            DB::rollback();    
        }    
    }
    public function getlist(Request $request){
        $data=Personal::selectRaw("personal_id,employee_id,employee_name")
            ->orderBy('descriptions','asc')->get();
        return response()->success('Success',$data);
    }

    public function open(Request $request){
        $filter = $request->filter;
        $limit = isset($request->limit) ? $request->limit : 100;
        $descending = $request->descending == "true";
        $sortBy = $request->sortBy;
        $pool_code = isset($request->pool_code) ? $request->pool_code :'';

        $data=Personal::selectRaw("personal_id,employee_id,personal_name,dob,personal_address,photo")
        ->where("pool_code",$pool_code)
        ->where("is_active",'1');
        if (!($filter == '')) {
            $filter = '%' . trim($filter) . '%';
            $data = $data->where(function ($q) use ($filter) {
                $q->where('employee_id', 'like', $filter);
                $q->orwhere('personal_name', 'like', $filter);
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
        $data=$data->toArray();
        $rows=array();
        $server=PagesHelp::my_server_url();
        foreach($data['data'] as $row){
            $row['photo_link']=$server.'/api/master/partner/driver/download?personal_id='.$row['personal_id']. '&document=photo';
            $rows[]=$row;
        }
        $data['data']=$rows;
        return response()->success('Success', $data);
    }
    
    public function upload(Request $request){
        $personal_id=$request->personal_id;
        $uploadedFile = $request->file('file');
        if ($uploadedFile){
            $originalFile = 'img_'.$personal_id.'_'.$uploadedFile->getClientOriginalName();        
            $directory="public/driver";
            $path = $uploadedFile->storeAs($directory,$originalFile);
            if ($request->document=='photo') {
                Personal::where('personal_id',$personal_id)
                ->update(['photo'=>$path]);
            } else if ($request->document=='ktp') {
                Personal::where('personal_id',$personal_id)
                ->update(['ktp'=>$path]);
            } else if ($request->document=='sim') {
                Personal::where('personal_id',$personal_id)
                ->update(['sim'=>$path]);
            } else if ($request->document=='kartu_keluarga') {
                Personal::where('personal_id',$personal_id)
                ->update(['kartu_keluarga'=>$path]);
            }
            return response()->success('Success', 'Upload data berhasil');
        }
   }
    public function download(Request $request)
    {
        $personal_id = isset($request->personal_id) ? $request->personal_id : -1;
        $document=isset($request->document) ? $request->document :'';
        $data=Personal::selectRaw(
            "IFNULL(photo,'') as photo,
             IFNULL(ktp,'') as ktp,
             IFNULL(sim,'') as sim,
             IFNULL(kartu_keluarga,'') as kartu_keluarga
             ")->where('personal_id',$personal_id)->first();
        if ($data) {
            if ($document=='photo'){
              $file=$data->photo;  
            } else if ($document=='ktp'){
              $file=$data->ktp;  
            } else if ($document=='sim'){
              $file=$data->sim;  
            } else if ($document=='kartu_keluarga'){
              $file=$data->kartu_keluarga;  
            }
            if ($file!=''){
                $publicPath = \Storage::url($file);
                $headers = array('Content-Type: application/image');
                return Storage::download($file);            
            }
        } else {
              return response()->error('',301,'Dokumen tidak ditemukan');
        }
    }

}