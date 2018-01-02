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

class AuthTokenController extends Controller{
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
        $this->checkParams($request);
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
        return response()->success([
            'access_token'=>$access_token,
            'expire_time'=>env('REDIS_EXPIRE_TIME'),
            'member_id'=>$user_info['id'],
            'memeber_name'=>$user_info['name'],
            'avatar'=>$user_info['avatar'],
            'rc_token'=>$user_info['rc_token'],
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
        $rc_token = $this->rcloud->getToken($member->id,$member->name,$member->avatar?:'');
        MembersModel::where('id',$member->id)->update(['rc_token'=>$rc_token]);
        return $member;
    }

    /**
     * facebook 获取用户信息
     * @param int $facebook_id
     * @return array
     */
    protected function facebook_userinfo($member_info){
        $member = MembersModel::create($member_info);
        $rc_token = $this->rcloud->getToken($member->id,$member->name,$member->avatar?:'');
        MembersModel::where('id',$member->id)->update(['rc_token'=>$rc_token]);
        return $member;
    }

    protected function get_token_key($access_token){
        return md5('user_'.$access_token);
    }

    public function checkParams($request)
    {
        if(!$request->get('member_name')){
            return response()->false('会员名必传');
        }
        if(!$request->get('open_id')){
            return response()->false('open标识必传');
        }
        if(!$request->get('open_type')){
            return response()->false('开放类型必须传');
        }
    }
}