<?php
// Place this file on the Providers folder of your project
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Config\USessions;
use Illuminate\Support\Facades\Hash;



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
        $factory->macro('success', function ($message = '', $data = null, $rowcount = 0,$respon_code=200) use ($factory,$request,$except) {
            $jwt     = $request->header('x_jwt');
            $uri     = strtolower($request->getPathInfo());
            $ignored = false;
            foreach ($except as $value) {
                $value=strtolower('/api/'.$value);
                if ($uri==$value){
                    $ignored = true;
                }
            }

            $method = $request->method();
            if ($request->isMethod('post')) {
                $respon_code=201;
                $message='Created';
            } else if (($request->isMethod('get')) || ($request->isMethod('delete'))) {
                $respon_code=200;
                $message='Accepted';
            }

            $header = [
                'status'=>'OK',
                'respon_code'=>$respon_code,
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
                $session=USessions::selectRaw("sign_code,now() as curr_time,user_name,refresh_date")
                ->where('sign_code',$jwt)
                ->first();
                if ($session) {
                    if ($session->curr_time>$session->refresh_date){
                        $token=Hash::make($session->user_name.$this->salt.Date('YmdHis'));
                        $refresh_date =  date('Y-m-d H:i:s', strtotime('+30 minutes'));
                        USessions::where('sign_code',$session->sign_code)
                            ->update(['sign_code'=>$token,
                                      'refresh_date'=>$refresh_date]);
                        $format = [
                                'header'=>$header,
                                'contents'=>$info,
                                'new_jwt'=>$token,
                                'time_stamp'=>$session->curr_time,
                                'refresh'=>$session->refresh_date
                            ];
                    }
                }
            }
            return $factory->make($format);
        });

        $factory->macro('error', function (string $message = '', $error_code = 400, $errors = []) use ($factory) {
            $header = [
                'status'=>'NOT_OK',
                'respon_code'=>$error_code,
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
