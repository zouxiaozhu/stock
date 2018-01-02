<?php
namespace App\Http\Controllers\ApiAuth;
use App\Http\Controllers\Api\Rongyun\Rcloud;
use \App\Http\Controllers\Controller;

use App\Http\Models\Backend\MembersModel;
use App\Http\Models\Backend\TerminalSettings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthTokenController extends Controller
{
    protected $appKey = 'lmxuhwagl0bwd';
    protected $appSecret = 'I6rR2XjU9R7Nu';
//	protected $jsonPath = "jsonsource/";
    const   SERVERAPIURL = 'http://api.cn.ronghub.com';    //IM服务地址
    const   SMSURL = 'http://api.sms.ronghub.com';          //短信服务地址
    protected static $_default_config = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0
    );
    public function __construct(Request $request,Rcloud $rcloud)
    {
        $this->request = $request;
        $this->_predis = new \Predis\Client([
            $config = array_merge(self::$_default_config, [
                'host'=>env('REDIS_HOST'),
                'port'=>env('REDIS_PORT'),
                'database'=>env('REDIS_DATABASE',0)
            ])
        ]);
        $this->rcloud = $rcloud;

    }


    public function checkToken(){

        $access_token = $this->request->get('access_token');

        $user_info  = $this->decode_access_token($access_token);
        if(!$user_info){
            return [];
        }
        return $user_info;
    }

    public function login(Request $request){
        if(!$request->get('member_name')){
            return response()->false('会员名必传');
        }
        if(!$request->get('open_id')){
            return response()->false('open标识必传');
        }
        if(!$request->get('open_type')){
            return response()->false('开放类型必须传');
        }
        //$password = $this->request->get('user_name');
        $open_type = $request->get('open_type') ? : 0;

        if(!$open_type || !in_array($open_type,[1,2,-1])){ //1 wechat 2 facebook
            return response()->error('0001','不合法的应用关联');
        }

        if($open_type == '2'){
            $facebook_id = $this->request->get('open_id',0);
            $user_info = MembersModel::where('open_id',$facebook_id)->where('source',$open_type)->first();
            if(!$user_info){

                $insert_data = [
                    'name'=>$request->get('member_name'),
                    'source'=>$open_type,
                    'phone'=>0,
                    'is_post'=>0,
                    'last_login_time'=>date("Y-m-d H:i:s"),
                    'rc_token'=>'',
                    'avatar'=>$request->get('avatar')?:"",
                    'open_id'=>$request->get('open_id')
                ];
                $user_info = $this->facebook_userinfo($insert_data);
            }

        }elseif($open_type=='1'){

            $wechat_open_id = $this->request->get('open_id',0);
            $user_info = MembersModel::where('open_id',$wechat_open_id)->where('source',$open_type)->first();

            if(!$user_info){
                $insert_data = [
                    'name'=>$request->get('member_name'),
                    'source'=>$open_type,
                    'phone'=>0,
                    'is_post'=>0,
                    'last_login_time'=>date("Y-m-d H:i:s"),
                    'rc_token'=>'',
                    'avatar'=>$request->get('avatar')?:"",
                    'open_id'=>$request->get('open_id')
                ];

                $user_info = $this->wechat_userinfo($insert_data);
            }
            // 插入数据
        }

        if(!$user_info){
            return response()->error(0006,'未知的用户信息');
        }
        // 查询对应的用户是否需要存库 更新相应字段 是否允许登录
        $access_token = $this->encode_access_token($user_info);

        if($this->_predis->get($access_token)){
            $this->_predis->del($access_token);
        }
        $redis_bool = $this->_predis->setex(
            $this->get_token_key($access_token),
            env('REDIS_EXPIRE_TIME',3600),
            json_encode($user_info)
        );
        if(!$redis_bool){
            return response()->error(0007,'存储信息失效');
        }
        $rc_token = $user_info['rc_token'];


        return response()->success([
            'access_token'=>$access_token,
            'expire_time'=>env('REDIS_EXPIRE_TIME'),
            'member_id'=>$user_info['id'],
            'member_name'=>$user_info['name'],
            'avatar'=>$user_info['avatar'],
            'rc_token'=>($user_info['rc_token']),
            'is_post'=>$user_info['is_post'],
        ]);
    }

    /**
     * 加密用户信息
     * @param array $user_info
     * @return bool
     */
    protected function encode_access_token($user_info=[]){
        if(!$user_info){
            return false;
        }
        $time=time();
        $micro = microtime();
        $user_info = json_encode($user_info);
        $sign = substr($time,-4,4).$user_info.substr($micro,4,4);

        $signature = Crypt::encrypt($sign);

        return $signature;
    }

    /**
     * 解密用户信息
     * @param string $access_token
     * @return bool
     */
    protected function decode_access_token($access_token=''){

        if(!$access_token){
            return false;
        }
        $signature = Crypt::decrypt($access_token);
        $signature = substr($signature,4,-4);
        $user_info = json_decode($signature,true);

        return $user_info;
    }

    /**
     * 微信获取用户信息
     * @param int $wechat_id
     * @return array
     */
    protected function wechat_userinfo($member_info){

        $member = MembersModel::create($member_info);
        $rc_token = $this->getToken($member->id,$member->name,$member->avatar?:'');
        $rc_token = json_decode($rc_token, true);
        $rc_token = $rc_token['token'];
        MembersModel::where('id',$member->id)->update(['rc_token'=>$rc_token]);
        $member['rc_token'] = $rc_token;
        return $member;
    }

    /**
     * facebook 获取用户信息
     * @param int $facebook_id
     * @return array
     */
    protected function facebook_userinfo($member_info){
        $member = MembersModel::create($member_info);
        $rc_token = $this->getToken($member->id,$member->name,$member->avatar?:'');
        $rc_token = json_decode($rc_token, true);
        $rc_token = $rc_token['token'];
        MembersModel::where('id',$member->id)->update(['rc_token'=>$rc_token]);
        $member['rc_token'] = $rc_token;
        return $member;
    }

    protected function get_token_key($access_token){
        return md5('user_'.$access_token);
    }



    /**
     * 获取 Token 方法
     *
     * @param  userId :用户 Id，最大长度 64 字节.是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）
     * @param  name :用户名称，最大长度 128 字节.用来在 Push 推送时显示用户的名称.用户名称，最大长度 128 字节.用来在 Push 推送时显示用户的名称。（必传）
     * @param  portraitUri :用户头像 URI，最大长度 1024 字节.用来在 Push 推送时显示用户的头像。（必传）
     *
     * @return $json
     **/
    public function getToken($user_id,$user_name,$avatar = '')
    {
        $userId = $user_id;
        $name   = $user_name;
        $portraitUri = $avatar;
        try {
            if (empty($userId))
                throw new Exception('用户id必传');

            if (empty($name))
                throw new Exception('用户名必传');

//            if (empty($portraitUri))
//                throw new Exception('用户头像必传');


            $params = array(
                'userId' => $userId,
                'name' => $name,
                'portraitUri' => $portraitUri
            );
            $ret = $this->curl('/user/getToken.json', $params, 'urlencoded', 'im', 'POST');
            if (empty($ret))
                throw new Exception('bad request');
            return $ret;

        } catch (Exception $e) {
//            print_r($e->getMessage());
            return response()->false(1000, $e->getMessage());
        }
    }


    /**
     * 发起 server 请求
     * @param $action
     * @param $params
     * @param $httpHeader
     * @return mixed
     */
    public function curl($action, $params, $contentType = 'urlencoded', $module = 'im', $httpMethod = 'POST')
    {
        switch ($module) {
            case 'im':
                $action = self::SERVERAPIURL . $action;
                break;
            case 'sms':
                $action = self::SMSURL . $action;
                break;
            default:
                $action = self::SERVERAPIURL . $action;
        }
        $httpHeader = $this->createHttpHeader();
        $ch = curl_init();
        if ($httpMethod == 'POST' && $contentType == 'urlencoded') {
            $httpHeader[] = 'Content-Type:application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->build_query($params));
        }
        if ($httpMethod == 'POST' && $contentType == 'json') {
            $httpHeader[] = 'Content-Type:Application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        if ($httpMethod == 'GET' && $contentType == 'urlencoded') {
            $action .= strpos($action, '?') === false ? '?' : '&';
            $action .= $this->build_query($params);
        }
        curl_setopt($ch, CURLOPT_URL, $action);
        curl_setopt($ch, CURLOPT_POST, $httpMethod == 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //处理http证书问题
//        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        if (false === $ret) {
            $ret = curl_errno($ch);
        }
        curl_close($ch);
        return $ret;
    }

    /**
     * 创建http header参数
     * @param array $data
     * @return bool
     */
    private function createHttpHeader()
    {
        $nonce = mt_rand();
        $timeStamp = time();
        $sign = sha1($this->appSecret . $nonce . $timeStamp);
        return array(
            'RC-App-Key:' . $this->appKey,
            'RC-Nonce:' . $nonce,
            'RC-Timestamp:' . $timeStamp,
            'RC-Signature:' . $sign,
        );
    }

    /**
     * 重写实现 http_build_query 提交实现(同名key)key=val1&key=val2
     * @param array $formData 数据数组
     * @param string $numericPrefix 数字索引时附加的Key前缀
     * @param string $argSeparator 参数分隔符(默认为&)
     * @param string $prefixKey Key 数组参数，实现同名方式调用接口
     * @return string
     */
    private function build_query($formData, $numericPrefix = '', $argSeparator = '&', $prefixKey = '')
    {
        $str = '';
        foreach ($formData as $key => $val) {
            if (!is_array($val)) {
                $str .= $argSeparator;
                if ($prefixKey === '') {
                    if (is_int($key)) {
                        $str .= $numericPrefix;
                    }
                    $str .= urlencode($key) . '=' . urlencode($val);
                } else {
                    $str .= urlencode($prefixKey) . '=' . urlencode($val);
                }
            } else {
                if ($prefixKey == '') {
                    $prefixKey .= $key;
                }
                if (isset($val[0]) && is_array($val[0])) {
                    $arr = array();
                    $arr[$key] = $val[0];
                    $str .= $argSeparator . http_build_query($arr);
                } else {
                    $str .= $argSeparator . $this->build_query($val, $numericPrefix, $argSeparator, $prefixKey);
                }
                $prefixKey = '';
            }
        }
        return substr($str, strlen($argSeparator));
    }

}