<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Config\USessions;

class Appauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $ignored_auth=true;

    public function handle($request, Closure $next)
    {
        $allowed = false;
        $jwt = $request->header('x_jwt');
        $md5=md5($jwt);
        $ip  = request()->ip();
        $session_jwt=USessions::selectRaw("now() as curr_time,expired_date,refresh_date,ip_number")
        ->where('sign_code',$md5)
        ->where('ip_number',$ip)
        ->first();
        if ($session_jwt) {
            if ($session_jwt->curr_time>$session_jwt->expired_date){
                USessions::where('sign_code',$md5)->delete();
                $message="token was expired, access dennied (APP-AUTH)";
            } else {
                $allowed= true;
            }
        } else {
            $message['message']="token invalid, access dennied (APP-AUTH)";
        }
        if (($allowed==true) || ($this->ignored_auth==true)){
            return $next($request);
        } else {
            return response()->error('',401,$message);
        }
    }
}
