<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24
 * Time: 12:00
 */
namespace App\Http\Controllers\ApiAuth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
trait ApiAuthTrait{
    public function decode_access_token($access_token=''){
        $this->_predis = new \Predis\Client([
            $config = array_merge(array(
                'host' => '127.0.0.1',
                'port' => 6379,
                'database' => 0
            ), [
                'host'=>env('REDIS_HOST'),
                'port'=>env('REDIS_PORT'),
                'database'=>env('REDIS_DATABASE',0)
            ])
        ]);
        $key = $access_token;

        $user_info = $this->_predis->get($key);
        if(!$user_info){
            return false;
        }
        $user_info = json_decode($user_info,true);
        return $user_info;
    }

    public function get_token_key($access_token)
    {
        return md5('user_'.$access_token);
    }
}
