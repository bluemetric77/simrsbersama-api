<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Config\USessions;


class Users extends Model
{
    protected $table = 'o_users';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $casts=[
        'is_active'=>'string',
        'is_group'=>'string'
    ];

    public static function UserProfile($username){
        $user = Users::selectRaw("sysid,user_name,full_name,password,user_level,is_active,sign,photo")
        ->where('user_name',$username)
        ->first();
        return $user;
    }

    public static function getUserinfo($token){
        $session=USessions::selectRaw("user_sysid")->where('sign_code',$token)->first();
        $user=Users::selectRaw("sysid,user_name,full_name,phone,password,user_level,failed_attemp,attemp_lock,ip_number,
        last_login,sign,photo,email,is_group,is_active")
        ->where('sysid',isset($session->user_sysid) ? $session->user_sysid :-1)
        ->where('is_active',true)
        ->where('is_group',false)->first();
        return $user;
  }

}
