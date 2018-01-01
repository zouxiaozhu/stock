<?php

namespace App\Http\Controllers\ApiAuth;

use \App\Http\Controllers\Controller;

use App\Http\Models\Backend\MembersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthTokenController extends Controller
{
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
                'host' => env('REDIS_HOST'),
                'port' => env('REDIS_PORT'),
                'database' => env('REDIS_DATABASE', 0)
            ])
        ]);
    }

    public function checkToken()
    {

        $access_token = $this->request->get('access_token');

        $user_info = $this->decode_access_token($access_token);
        if (!$user_info) {
            return [];
        }
        return $user_info;
    }

    public function login()
    {
        //1.接收第三方登录信息和open_id
        $user_name = $this->request->get('user_name', '');
        if (!$user_name) {
            return response()->false('1314', '用户名不存在');
        }
        $avatar = $this->request->get('avatar', '');
        $open_type = $this->request->get('open_type') ?: 1;

        if (!$open_type || !in_array($open_type, [1, 2, -1])) {
            //1 wechat 2 facebook
            return response()->error('0001', '不合法的应用关联');
        }

        $open_id = $this->request->get('open_id', 0);
        if (!$open_id) {
            return response()->false('1413', 'open_id不存在');
        }

//        if ($open_type == '2') {
//            $facebook_id = $this->request->get('facebook_open_id', 0);
//            if (!$facebook_id) {
//                return response()->error(0004, '没有facebook信息');
//            }
//            $user_info = $this->facebook_userinfo($facebook_id);
//        } elseif ($open_type == '1') {
//            $wechat_open_id = $this->request->get('wechat_open_id', 0);
//            if (!$wechat_open_id) {
//                return response()->error(0005, '没有wechat信息');
//            }
//            // 插入数据
//            $user_info = $this->wechat_userinfo($wechat_open_id);
//
//            $user_info = [
//                'member_id' => 1,
//                'member_name' => 'zhanglong',
//                'member_open_id' => 'sdasdasd',
//                'source' => 1
//            ];
//        } else {
//            $user_name = $this->request->get('user_name');
//            $password = $this->request->get('password');
//        }
        $open_data = [
            'open_type' =>  $open_type,
            'open_id'   =>  $open_id,
        ];
        //2.查询用户是否已经存在
        $exist_result = $this->_userExist($open_data);

        //3.若果用户不存在,则插入数据库
        if (!$exist_result) {
            $member_regist = MembersModel::create([
                'source'    =>  $open_type,
                'open_id'   =>  $open_id,
                'nick_name' =>  $user_name,
                'avatar'    =>  $avatar
            ])->toArray();
            if (!$member_regist) {
                return response()->false('1580', '登录失败');
            }
            $member_id = $member_regist['id'];
            $user_info = [
                'source'    =>  $open_type,
                'open_id'   =>  $open_id,
                'nick_name' =>  $user_name,
                'id'        =>  $member_id,
                'avatar'    =>  $avatar,
            ];
        } else {
            $user_info = $exist_result[0];
        }

        $access_token = $this->encode_access_token($user_info);
//        $access_token = str_pad($access_token, 16);
//        echo $access_token;die;
        if ($this->_predis->get($access_token)) {
            $this->_predis->del($access_token);
        }
        $redis_bool = $this->_predis->setex(
            $this->get_token_key($access_token),
            env('REDIS_EXPIRE_TIME', 3600),
            json_encode($user_info)
        );
        if (!$redis_bool) {
            return response()->error(0007, '存储信息失效');
        }
        return response()->success([
            'access_token' => $access_token,
            'expire_time' => env('REDIS_EXPIRE_TIME'),
            'user_id'       =>  $user_info['id'],
            'user_name'     =>  $user_info['nick_name'],
            'avatar'        =>  $avatar,
        ]);
    }


    private function _userExist($open_data)
    {
        if (!$open_data) {
            return false;
        }

        $memeber_info = MembersModel::select('source', 'open_id', 'nick_name', 'id', 'avatar')
            ->where('open_id', $open_data['open_id'])
            ->where('source', $open_data['open_type'])
            ->take(1)
            ->get()
            ->toArray();
        return $memeber_info;
    }

    /**
     * 加密用户信息
     * @param array $user_info
     * @return bool
     */
    protected function encode_access_token($user_info = [])
    {
        if (!$user_info) {
            return false;
        }
        $time = time();
        $micro = microtime();
        $user_info = json_encode($user_info);
        $sign = substr($time, -4, 4) . $user_info . substr($micro, 4, 4);

        $signature = Crypt::encrypt($sign);

        return $signature;
    }

    /**
     * 解密用户信息
     * @param string $access_token
     * @return bool
     */
    protected function decode_access_token($access_token = '')
    {

        if (!$access_token) {
            return false;
        }
        $signature = Crypt::decrypt($access_token);
        $signature = substr($signature, 4, -4);
        $user_info = json_decode($signature, true);

        return $user_info;
    }

    /**
     * 微信获取用户信息
     * @param int $wechat_id
     * @return array
     */
    protected function wechat_userinfo($wechat_id = 0)
    {
        if (!$wechat_id) {
            return [];
        }

        $memeber_info = MembersModel::where('open_id', $wechat_id)->where('source', 1)->get()->toArray();
        // 获取用户信息 并放入到用户信息表
        if (!$memeber_info) {

        }
        return $memeber_info;

    }

    /**
     * facebook 获取用户信息
     * @param int $facebook_id
     * @return array
     */
    protected function facebook_userinfo($facebook_id = 0)
    {
        if (!$facebook_id) {
            return [];
        }
        // 获取用户信息 并放入到用户信息表
    }

    protected function get_token_key($access_token)
    {
        return md5('user_' . $access_token);
    }
}