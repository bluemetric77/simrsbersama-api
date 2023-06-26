<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\Users;
use App\Models\Config\USessions;
use App\Models\Config\Parameters;
use App\Models\Config\UserObjects;
use App\Models\Config\UserReports;
use App\Models\Config\Objects;
use App\Models\Config\Reports;
use PagesHelp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    private $salt='$2y$06$Pi1ND0N3S1A#&m3Rd3K4#@%!';

    public function index(Request $request)
    {
        $token=$request->header('x_jwt');
        $filter = $request->filter;
        $limit = $request->limit;
        $sorting = ($request->descending=="true") ? "desc":"asc";
        $sortBy = $request->sortBy;
        $user=USessions::user($token);
        $data= Users::selectRaw("sysid,user_name,full_name,photo,email,is_group,
                is_active,user_level,uuid_rec");
        if (!($filter=='')){
            $filter='%'.trim($filter).'%';
            $data=$data->where(function($q) use ($filter) {
                    $q->where('user_name','like',$filter)
                    ->orwhere('full_name','like',$filter)
                    ->orwhere('email','like',$filter);
            });
        }
        if (!($user->user_level=='ADMIN')){
            $data=$data->where('user_name',$userid);
        }
        $data=$data->orderBy($sortBy,$sorting)->paginate($limit);
        $data=$data->toArray();
        $rows=array();
        $server=PagesHelp::my_server_url();
        foreach($data['data'] as $row){
            $row['photo']=$server.'/'.$row['photo'];
            $rows[]=$row;
        }
        $data['data']=$rows;
        return response()->success('Success',$data);
    }

    public function profile(Request $request){
       $jwt=$request->header('x_jwt');
       $data=USessions::selectRaw('user_sysid,user_name')->where('sign_code',$jwt)->first();
       if ($data){
           $data=Users::selectRaw("sysid,user_name,full_name,email,photo,sign")
           ->where('sysid',$data->user_sysid)
           ->first();
           if ($data){
                $server=PagesHelp::my_server_url();
                $data['photo']=$server.'/'.$data['photo'];
                $data['sign']=$server.'/'.$data['sign'];
           }
           return response()->success('Success',$data);
       } else {
          return response()->error('',501,"Error");
       }
    }

    public function get(Request $request)
    {
        $uuid=isset($request->uuid) ? $request->uuid :'';
        $users = Users::selectRaw("sysid,user_name,full_name,phone,email,is_group,
                is_active,user_level,uuid_rec")
            ->where('uuid_rec',$uuid)
            ->first();
        return response()->success('',$users,1);
    }

    public function post(Request $request)
    {
        $data= $request->json()->all();
        $row=$data['data'];
        $opr=$data['operation'];
        $where=$data['where'];
        $validator=Validator::make($row,
        [
            'user_name'=>'bail|required',
            'full_name'=>'bail|required',
            'is_group'=>'bail|required',
            'user_level'=>'bail|required',
            'email'=>'bail|required',
        ],[
            'user_name.required'=>'User ID harus disi harus diisi',
            'full_name.required'=>'Nama user barus harus diisi',
            'is_group.required'=>'Type user harus diisi',
            'user_level.required'=>'Level user harus diisi',
            'email.required'=>'Email harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }

        DB::beginTransaction();
        try{
            if ($opr=='inserted'){
                $user = new Users();
                $user->uuid_rec=Str::uuid()->toString();
            } else if ($opr=='updated'){
                $user = Users::where('uuid_rec',$row['uuid_rec'])->first();
            }
            if ($user){
                $user->user_name=$row['user_name'];
                $user->full_name=$row['full_name'];
                $user->is_group=$row['is_group'];
                $user->user_level=$row['user_level'];
                $user->email=$row['email'];
                $user->phone=$row['phone'];
                $user->is_active=$row['is_active'];
                $user->update_userid=PagesHelp::UserID($request);
                $user->save();
                DB::commit();
                $info['uuid']=$user->uuid_rec;
                $info['message']='Simpan/update data berhasil';
                return response()->success('success',$info);
            }
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function post_profile(Request $request)
    {
        $data= $request->json()->all();
        $row=$data['data'];
        $where=$data['where'];

        $jwt=$request->header('x_jwt');
        $md5=md5($jwt);
        $session=DB::table('o_session')->select('user_id',)->where('md5_hash',$md5)->first();
        if ($session){
           $user=Users::select('sysid')->where('user_id',$session->user_id)->first();
        }

        DB::beginTransaction();
        try{
            $sysid=$user->sysid;
            Users::where('sysid',$sysid)
            ->update([
                'user_name'=>$row['user_name'],
                'email'=>$row['email'],
                'phone'=>$row['phone'],
            ]);
            DB::commit();
            return response()->success('success','Update data berhasil');
		} catch (Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function save_security(Request $request){
        $jwt=$request->header('x_jwt');
        $userid=Users::getuserIDfromJWT($jwt);
        $user=Users::UserProfile($userid);
        if (!($user->user_level=='ADMIN')){
            return response()->error('',501,'You have not authorized');
        }
        $data= $request->json()->all();
	    $sysid = $data['sysid'];
        $security  = $data['access'];
        $reports   = $data['report'];
        DB::beginTransaction();
        try{
            UserObjects::where('sysid',$sysid)->delete();
            foreach ($security as $line) {
                $main = $line['main'];
                foreach ($main as $detail) {
                    if ($detail['header']==0) {
                        $objid = $detail['object_id'];
                        $objsecurity=json_encode($detail['security']);
                        if (!($objsecurity=='[]')) {
                            UserObjects::insert([
                                    'sysid' => $sysid,
                                    'object_id'=> $objid,
                                    'security' => $objsecurity
                                ]);
                        }
                    }
                    if ($detail['header']==1){
                        $sub =$detail['detail'];
                        foreach ($sub as $subdetail) {
                            $objid = $subdetail['object_id'];
                            $objsecurity=json_encode($subdetail['security']);
                            if (!($objsecurity=='[]')) {
                                UserObjects::insert([
                                        'sysid' => $sysid,
                                        'object_id'=> $objid,
                                        'security' => $objsecurity
                                    ]);
                            }
                        }
                    }
                }
            }
            UserReports::where('sysid',$sysid)->delete();
            foreach ($reports as $report) {
               if ($report['is_header']=='0') {
                UserReports::insert([
                    'user_sysid'=>$sysid,
                    'report_sysid'=>$report['sysid'],
                    'is_allow'=>$report['is_selected'],
                    'is_export'=>isset($report['is_selected']) ? $report['is_selected'] :false
                ]);
               }
            }
            DB::commit();
            return response()->success('success','Simpan data berhasil');
		} catch (\Exception $e) {
            DB::rollback();
            return response()->error('',501,$e);
        }
    }

    public function delete(Request $request){
        $uuid=isset($request->uuid) ? $request->uuid :'';
        $data=Users::selectRaw("sysid")->where('uuid_rec',$uuid)->first();
        if ($data) {
            DB::beginTransaction();
            try{
                Users::where('sysid',$data->sysid)->delete();
                UserObjects::where('user_sysid',$data->sysid)->delete();
                DB::commit();
                return response()->success('Success','Data berhasil dihapus');
            } catch(\Exception $e) {
               return response()->error('',501,$e);
               DB::rollback();
            }
        } else {
           return response()->error('',501,'Data tidak ditemukan');
        }
    }

    public function changepassword(Request $request){
        $validator=Validator::make($request,
        [
            'pwdold'=>'bail|required',
            'pwd1'=>'bail|required',
            'pwd2'=>'bail|required',
        ],[
            'pwdold.required'=>'Password lama harus disi harus diisi',
            'pwd1.required'=>'Password barus harus diisi',
            'pwd2.required'=>'Password konfirmasi harus diisi',
        ]);
        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        $token=$request->header('x_jwt');
        $user=USessions::user($token);
        $sysid=$user->sysid;
        $old_pwd=isset($request->pwdold) ? $request->pwdold :'';
        $old_pwd=$old_pwd.$this->salt;
        $pwd1=$request->pwd1;
        $pwd2=$request->pwd2;

        if (Hash::check($old_pwd, $user->password)) {
            return response()->error('',501,'Password lama salah');
        }
        if (!($pwd1==$pwd2)){
            return response()->error('',501,'Konfirmasi password berbeda');
        }
        try{
            Users::where('sysid',$sysid)
                ->update(['password'=>Hash::make($pwd1.$this->salt)]);
            return response()->success('success','Ubah password berhasil');
		} catch (Exception $e) {
            return response()->error('',501,$e);
        }
    }

    public function changepwd(Request $request){
        $validator=Validator::make($request->all(),
        [
            'pwd1'=>'bail|required',
            'pwd2'=>'bail|required',
        ],[
            'pwd1.required'=>'Password barus harus diisi',
            'pwd2.required'=>'Password konfirmasi harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->error('',501,$validator->errors()->first());
        }
        $token=$request->header('x_jwt');
        $user=USessions::user($token);
        if (!($user->user_level=='ADMIN')){
            if (!($user->sysid==$request->sysid)){
                return response()->error('',501,'Tidak diizinkan untuk mengubah password');
            }
        }
        $uuid=$request->uuid;
        $pwd1=$request->pwd1;
        $pwd2=$request->pwd2;
        if (!($pwd1==$pwd2)){
            return response()->error('',501,'Password konfirmasi berbeda');
        }
        try{
            $pwd=Hash::make($pwd1.$this->salt);
            Users::where('uuid_rec',$uuid)
                ->update(['password'=>$pwd]);
            return response()->success('success','Ubah password berhasil');
		} catch (Exception $e) {
            return response()->error('',501,$e);
        }
    }

    public function getObjAccess(Request $request){
        $sysid= isset($request->sysid)?$request->sysid:-1;
        $pool_code=isset($request->pool_code) ? $request->pool_code:'';
        $item = UserObjects::select('object_sysid','security')
              ->where('user_sysid',$sysid)
              ->get();
            return response()->success('Success',$item);
    }

    public function getItem(Request $request){
        $item = Objects::selectRaw('sysid,parent_sysid,sort_number,title,icons,is_parent,security')
            ->where('is_active',true)
            ->distinct()
            ->orderBy('sort_number')
            ->get();
        return response()->success('Success',$item);
    }
    public function getItemAccess(Request $request){
        $item = Objects::selectRaw('sysid,parent_sysid,sort_number,title,icons,is_parent,security')
            ->where('is_active',true)
            ->where('is_parent',false)
            ->distinct()
            ->orderBy('sort_number')
            ->get();
        return response()->success('Success',$item);
    }

    public function uploadfoto(Request $request)
    {
        $sysid  = isset($request->sysid) ? $request->sysid : '';
        $sysid  = strval($sysid);
        $uploadedFile = $request->file('file');
        $originalFile = $uploadedFile->getClientOriginalName();
        $originalFile = Date('Ymd-His')."-".$originalFile;
        $directory="public/user";
        $path = $uploadedFile->storeAs($directory,$originalFile);
        Users::where('sysid',$sysid)->update(['photo'=>$path]);
        $server=PagesHelp::my_server_url();
        $respon['path_file']=$server.'/'.$path;
        $respon['message']='Upload foto berhasil';
        return response()->success('success',$respon);
    }

    public function uploadsign(Request $request)
    {
        $sysid  = isset($request->sysid) ? $request->sysid : '';
        $sysid  = strval($sysid);
        $uploadedFile = $request->file('file');
        $originalFile = $uploadedFile->getClientOriginalName();
        $originalFile = Date('Ymd-His')."-".$originalFile;
        $directory="public/sign";
        $path = $uploadedFile->storeAs($directory,$originalFile);
        Users::where('sysid',$sysid)->update(['sign'=>$path]);
        $server=PagesHelp::my_server_url();
        $respon['path_file']=$server.'/'.$path;
        $respon['message']='Upload foto berhasil';
        return response()->success('success',$respon);
    }

    public function user_group(Request $request) {
        $data= Users::selectRaw("user_name,full_name")
        ->where('is_group',true)
        ->where('is_active',true)
        ->orderBy('full_name','asc')
        ->get();
        return response()->success('success',$data);
   }
}
