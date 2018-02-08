<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/8
 * Time: 23:32
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Hook extends Controller{
    protected  $token ;

    public function __construct()
    {
        $this->token =  Config::get('hook.hook_token');
    }


    public function pull(Request $request)
    {
        file_put_contents('/tmp/xx',var_export($request->all(),1),8);
        echo 111;
    }

}