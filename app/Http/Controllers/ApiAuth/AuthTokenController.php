<?php
namespace App\Http\Controllers\ApiAuth;
use \App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthTokenController extends Controller{
    protected static $_default_config = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0
    );
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_predis = new \Predis\Client([
            $config = array_merge(self::$_default_config, [
                'host'=>env('REDIS_HOST'),
                'port'=>env('REDIS_PORT'),
                'database'=>env('REDIS_DATABASE','')
            ])
        ]);
    }

    public function checkToken(){
        $access_token = $this->request->get('access_token');
        $token_bool = $this->decode_access_token($access_token);

    }

    public function login(){
        //
        //$password = $this->request->get('user_name');
        $open_type = $this->request->get('open_type') ? : '';
        if(!$open_type){
            return response()->error();
        }
        if($open_type == 'facebook'){
            $user_info = $this->facebook_userinfo();
        }elseif($open_type=='wechat'){
            $user_info = $this->wechat_userinfo();
        }
        // 查询对应的用户是否需要存库 更新相应字段 是否允许登录
        $access_token = $this->encode_access_token($user_info);
        $this->_predis->setnx('user_'.$user_info['user_id'],$access_token);
        return response()->success([
            'access_token'=>$access_token,
            'expire_time'=>env('REDIS_EXPIRE_TIME')
        ]);
    }
    protected function encode_access_token($user_info=[]){
        if(!$user_info){
            return false;
        }
        $time=time();
        $user_info = json_encode($user_info);
        $sign = substr($time,-1,4).$user_info.substr($time,4,4);
        $signature = Crypt::encrypt($sign);
        return $signature;
    }
    protected function decode_access_token($access_token=''){
        if(!$access_token){
            return false;
        }
        $signature = Crypt::decrypt($access_token);
        $user_info = json_decode(substr($signature,4,-4),true);
        //panduan expire_time
        if($this->_predis->get('user_'.$user_info['user_id'])){
            return true;
        }
        return false;
    }
}