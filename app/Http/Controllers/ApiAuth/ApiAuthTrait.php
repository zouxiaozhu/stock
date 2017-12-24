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

        if(!$access_token){
            return false;
        }
        try {
            $signature = Crypt::decrypt($access_token);
            if(!$signature){
                throw  new DecryptException('异常');
            }
        } catch (DecryptException $e) {
            return false;
        }
        $signature = substr($signature,4,-4);
        $user_info = json_decode($signature,true);

        return $user_info;
    }

}
