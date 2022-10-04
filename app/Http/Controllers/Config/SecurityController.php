<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config\Users;
use App\Models\Config\USessions;
use App\Models\Config\Sites;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    public function Verified(Request $request){
        $jwt = $request->jwt;
        $md5 = md5($jwt);
        $session=USessions::selectRaw("now() as curr_time,expired_date,refresh_date,is_locked")
        ->where('sign_code',$md5)
        ->first();
        $data= array();
        if ($session) {
            if ($session->curr_time>$session->expired_date){
                $data['allowed']=false;
                $data['is_locked']=false;
                USessions::where('sign_code',$md5)->delete();
                return response()->error('Unallowed page',301,$data);
            } else {
                $data['allowed']=true;
                $data['is_locked'] = ($session->is_locked==1);
                if ($session->curr_time>$session->refresh_date){
                    $user = decrypt($jwt);
                    $token = encrypt($user);
                    $refresh_date =  date('Y-m-d H:i:s', strtotime('+30 minutes'));
                    $data['new_jwt'] = $token;
                    $md5=md5($token);
                    USessions::where('sign_code',$md5) 
                    ->update(['refresh_date'=>$refresh_date]);
                }
                return response()->success('Allowed page',$data);
            }
        } else {
            $data['allowed']=false;
            return response()->error('Unallowed page',301,$data);
        }
    }

    public function getSecurityForm( Request $request){
        $jwt = $request->jwt;
        $userid=Users::getuserIDfromJWT($jwt);
        $usrinfo=Users::getUserinfo($userid);
        if ($usrinfo) {
            $sysid=$usrinfo->sysid;
            $security_level=$usrinfo->user_level;
            if ($security_level=='USER'){
                $item = DB::table('o_object_items')
                ->select('id','group_id','title','image','objectid','icon','hints','url_link')
                ->where('is_header','0')
                ->distinct()
                ->get();
            } else {
                $item = DB::table('o_object_items')
                ->select('id','group_id','title','image','objectid','icon','hints','url_link')
                ->where('is_header','0')
                ->distinct()
                ->get();
            }
            return response()->success('Success',$item);
        }
    }

    public function checklogin(Request $request){
        $userid=isset($request->user_id) ? $request->user_id :'';
        $password=isset($request->password) ? $request->password:'';
        $validator=Validator::make($request->all(),[
            'user_id'=>'bail|required',
            'password'=>'bail|required'
        ],[
            'user_id.required'=>'User ID harus diisi',
            'password.required'=>'Password harus diisi'
        ]);
        if ($validator->fails()){
            return response()->error('',501,$validator->errors()->first());
        }

        $data=Users::UserProfile($userid);
        if (!($data)) {
            return response()->error('',301,"User ID/Password salah");
        }
        $curr_date= date('Y-m-d H:i:s');
        if ($data->failed_attemp>=3) {
            if ($data->attemp_lock > $curr_date) {
                $date =date_format(date_create($data->attemp_lock),'d-m-Y H:i:s');
                return response()->error('',301,"User anda terkunci, Anda dapat login lagi $date");
            } else {
                Users::where('user_id',$userid)
                    ->update(['failed_attemp'=>0,
                            'attemp_lock'=>null]);
                $data=Users::getUserinfo($userid);
            }
        }
        if ($data) {
            DB::beginTransaction();
            try{
                Users::where('user_name',$userid)
                    ->where('failed_attemp','>',3)
                    ->update(['failed_attemp'=>0,
                            'attemp_lock'=>null]);
                $pwd=$data->password;
                $pwd=decrypt($pwd);
                if ($pwd==$password){
                    $token=$this->generate_jwt($data->sysid,$data->user_name,$data->full_name,'N/A');
                    Users::where('user_name',$userid)
                        ->update([
                            'failed_attemp'=>0,
                            'attemp_lock'=>null,
                            'session_number'=>session()->getId(),
                            'ip_number'=>request()->ip(),
                            'last_login'=>date('Y-m-d H:i:s')]);
                    $return=(object) array(
                        'user_name'=>$data->user_name,
                        'full_name'=>$data->full_name,
                        'token'=>$token,
                    );
                    DB::commit();
                    return response()->success('Berhasil',$return);
                } else {
                    $failed = $data->failed_attemp + 1;
                    $retry = strval(3 - $failed);
                    Users::where('user_name',$userid)
                        ->update(['failed_attemp'=>$failed]);
                    if ($retry>0){     
                        DB::commit();
                        return response()->error('',301,"User id/Password salah");
                    } else {
                        $date =  date('Y-m-d H:i:s', strtotime('3 minute'));
                        Users::where('user_id',$userid)
                                ->update(['attemp_lock'=>$date]);
                        $date =  date('d-m-Y H:i:s', strtotime('3 minute'));
                        DB::commit();
                        return response()->error('',301,"3 kali login gagal, Anda dapat login lagi $date");
                    }
                }
            } 
            catch (\Exception $e) {
                return response()->error('',301,"Internal server Error (User Verification");
                DB::rollback();
            }
        } else {
            return response()->error('',301,"User id/Password salah");
        }
    }
    function generate_jwt($sysid,$user_name,$full_name,$sitecode){
        $token=encrypt($user_name.'##'.$sitecode.'.'.Date('Y-m-d H:i:s'));
        $md5=md5($token);
        $create_date  = date('Y-m-d H:i:s');
        $expired_date =  date('Y-m-d H:i:s', strtotime('+1 days'));
        $refresh_date =  date('Y-m-d H:i:s', strtotime('+1 days'));
        USessions::where('expired_date','<',$create_date)->delete();
        session()->regenerate();
        USessions::insert([
            'sign_code'=>$md5,
            'session_number'=>session()->getId(),
            'user_sysid'=>$sysid,
            'user_name'=>$user_name,
            'ip_number'=>request()->ip(),
            'expired_date'=>$expired_date,
            'refresh_date'=>$refresh_date,
            'is_locked'=>false,
            'create_date'=>Date('Y-m-d H:i:s')
            ]);
        return $token;
    }

    public function logout(Request $request){
        $ip  = request()->ip();
        $jwt=$request->input('x_jwt');
        $sign_code=md5($jwt);
        $sessionid=session()->getId();
        USessions::where('sign_code',$sign_code)
        ->delete();
         session()->regenerate();
         return response()->success('Logout',null);
    }
}
