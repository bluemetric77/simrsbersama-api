<?php
// Place this file on the Providers folder of your project
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Config\USessions;



class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected $except = [
        'login',
        'logout',
        'profile',
        'home/item',
        'access/securitypage',
        'access/pageaccess'
    ];

    public function boot(ResponseFactory $factory)
    {
        $request = $this->app->request;
        $except = $this->except;
        $factory->macro('success', function ($message = '', $data = null, $rowcount = 0) use ($factory,$request,$except) {
            $jwt = $request->header('x_jwt');
            $md5 = md5($jwt);
            $uri=strtolower($request->getPathInfo());
            $ignored=false;
            foreach ($except as $value) {
                $value=strtolower('/api/'.$value);
                if ($uri==$value){ 
                    $ignored = true;
                }
            }
            $header = [
                'status'=>'OK',
                'error_no'=>0,
                'message'=>$message
            ];
            
            $info = [
                'success'=>true,
                'rowcount'=>$rowcount,
                'data'=>$data
            ];
            $format = [
                'header'=>$header,
                'contents'=>$info
            ];  

            if ((!($jwt=="")) && ($ignored==false)) {    
                $session=USessions::selectRaw("sign_code,now() as curr_time,refresh_date")
                ->where('sign_code',$md5)->first();
                if ($session) {
                    if ($session->curr_time>$session->refresh_date){
                        $user = decrypt($jwt);
                        $token = encrypt($user);
                        $md5=md5($token);
                        $refresh_date =  date('Y-m-d H:i:s', strtotime('+30 minutes'));
                        USessions::where('sign_code',$session->sign_code) 
                            ->update(['sign_code'=>$md5,
                                      'refresh_date'=>$refresh_date]);
                        $format = [
                                'header'=>$header,
                                'contents'=>$info,
                                'new_jwt'=>$token
                            ];    
                    }
                }
            }
            return $factory->make($format);
        });

        $factory->macro('error', function (string $message = '', $error_code = 0, $errors = []) use ($factory) {
            $header = [
                'status'=>'NOT_OK',
                'error_no'=>$error_code,
                'message'=>$message
            ];
            $info = [
                'success'=>false,
                'data'=>$errors
            ];

            $format = [
                'header'=>$header,
                'contents'=>$info
            ];    
            return $factory->make($format);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $request = $this->app->request;
    }
}
