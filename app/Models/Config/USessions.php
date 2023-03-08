<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Config\Users;
class USessions extends Model
{
    protected $table = 'o_sessions';
    protected $primaryKey = 'sign_code';
    protected $primaryType= 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';

    public static function user($token){
        $session=USessions::selectRaw("user_sysid")->where('sign_code',$token)->first();
        $user=Users::selectRaw("sysid,user_name,full_name,phone,password,user_level,failed_attemp,attemp_lock,ip_number,
        last_login,sign,photo,email,is_group,is_active")
        ->where('sysid',isset($session->user_sysid) ? $session->user_sysid :-1)
        ->where('is_active',true)
        ->where('is_group',false)->first();
        return $user;
  }
}
