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

    public function __construct(Request $request)
    {
        $this->token =  Config::get('hook.hook_token');
        $token = $request->get('token','');
        if(!$token) {echo 'pull failed';die;}
    }


    public function pull()
    {

        file_put_contents('/etc/GitSign.php',1);
        file_put_contents('/etc/GitSign_log.php',"ok".PHP_EOL);
        echo 111;
    }

    public function test()
    {

        var_export(date('Y-m-d H:i:s'));
        var_export(1111);
    }


}