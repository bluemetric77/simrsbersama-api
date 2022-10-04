<?php

namespace App\Models\Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'o_users';
    protected $primaryKey = 'sysid';
    public $timestamps = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    protected $casts=[
        'is_active'=>'boolean',
        'is_group'=>'boolean'
    ];

    public static function UserProfile($username){
        $user = Users::selectRaw("sysid,user_name,full_name,password,user_level,is_active,sign,photo")
        ->where('user_name',$username)
        ->first();
        return $user;
    }

    public static function getuserIDfromJWT($jwt){
        $data = decrypt($jwt);
        $index = strpos($data,'##');
        return substr($data,0,$index);
    }
    
}
