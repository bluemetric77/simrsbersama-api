<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config\Users;
use App\Models\Config\USessions;
use App\Models\Config\UserObjects;
use Illuminate\Support\Facades\Hash;
use App\Models\Config\Sites;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    private $salt='$2y$06$Pi1ND0N3S1A#&m3Rd3K4#@%!';

    public function Verified(Request $request){
        $token = isset($request->jwt) ? $request->jwt :'';
        $objects = $request->objects;
        $session=USessions::selectRaw("now() as curr_time,expired_date,refresh_date,is_locked,user_sysid,user_name")
        ->where('sign_code',$token)
        ->first();
        $data= array();
        if ($session) {
            if ($session->curr_time>$session->expired_date){
                $data['is_login']=false;
                $data['is_allowed']=false;
                $data['is_locked'] = ($session->is_locked==1);
                USessions::where('sign_code',$token)->delete();
                return response()->error('Halaman ini tidak diizinkan',301,$data);
            } else {
                $data['is_login']=true;
                $data['is_allowed']=false;
                if ($session->curr_time>$session->refresh_date){
                    $token = Hash::make($session->user_name.$this->salt.Date('YmdHis'));
                    $refresh_date =  date('Y-m-d H:i:s', strtotime('+6 hours'));
                    $data['new_jwt'] = $token;
                    USessions::where('sign_code',$token)
                    ->update(['refresh_date'=>$refresh_date]);
                }
                if (!($objects=="/")){
                    $user=USessions::user($token);
                    if ($user){
                        if (!($user->user_level=='USER')) {
                            $data['is_allowed']=true;
                        } else {
                            if (UserObjects::from('o_users_access as a')
                            ->join('o_objects as b',"a.object_sysid","=","b.sysid")
                            ->where("a.sysid",$user->$sysid)
                            ->where("b.url_link",$objects)->exist()){
                                $data['is_allowed']=true;
                            }
                        }
                    }
                } else {
                    $data['is_allowed']=true;
                }
                return response()->success('Halaman diizinkan',$data);
            }
        } else {
            $data['is_login']=false;
            $data['is_allowed']=false;
            return response()->error('Halamn tidak diizinkan',301,$data);
        }
    }

    public function getSecurityForm( Request $request){
        $token = isset($request->jwt) ? $request->jwt :'';
        $user=USessions::user($token);
        if ($user) {
            $sysid=$user->sysid;
            $security_level=$user->user_level;
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

        $data=Users::where('user_name',$userid)->first();
        if (!($data)) {
            return response()->error('',301,"User ID/Password salah");
        }
        $curr_date= date('Y-m-d H:i:s');
        if ($data->failed_attemp>=3) {
            if ($data->attemp_lock > $curr_date) {
                $date =date_format(date_create($data->attemp_lock),'d-m-Y H:i:s');
                return response()->error('',301,"User anda terkunci, Anda dapat login lagi $date");
            } else {
                Users::where('user_name',$userid)
                    ->update(['failed_attemp'=>0,
                            'attemp_lock'=>null]);
                $data=Users::where('user_name',$userid)->first();
            }
        }
        if ($data) {
            DB::beginTransaction();
            try{
                Users::where('user_name',$userid)
                    ->where('failed_attemp','>',3)
                    ->update(['failed_attemp'=>0,
                            'attemp_lock'=>null]);
                $password=$password.$this->salt;
                if (Hash::check($password, $data->password)) {
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
            catch (Exception $e) {
                return response()->error('',301,"Internal server Error (User Verification)");
                DB::rollback();
            }
        } else {
            return response()->error('',301,"User id/Password salah");
        }
    }
    function generate_jwt($sysid,$user_name,$full_name,$sitecode){
        $token=Hash::make($user_name.$this->salt.Date('YmdHis'));
        $create_date  = date('Y-m-d H:i:s');
        $expired_date =  date('Y-m-d H:i:s', strtotime('+1 days'));
        $refresh_date =  date('Y-m-d H:i:s', strtotime('+6 hours'));
        USessions::where('expired_date','<',$create_date)->delete();
        session()->regenerate();
        USessions::insert([
            'sign_code'=>$token,
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
        $sessionid=session()->getId();
        USessions::where('sign_code',$sign_code)
        ->delete();
        session()->regenerate();
        return response()->success('Logout',null);
    }
}
