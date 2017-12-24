<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24
 * Time: 12:00
 */
namespace App\Http\Controllers\ApiAuth;
use Illuminate\Support\Facades\Crypt;
trait ApiAuthTrait{
    public function decode_access_token($access_token=''){

        if(!$access_token){
            return false;
        }
        $signature = Crypt::decrypt($access_token);
        $signature = substr($signature,4,-4);
        $user_info = json_decode($signature,true);

        return $user_info;
    }

}
