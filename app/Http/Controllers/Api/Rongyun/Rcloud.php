<?php
/**
 * 融云 Server API PHP 客户端
 * create by kitName
 * create datetime : 2017-02-09 
 * 
 * v2.0.1
 */
namespace App\Http\Controllers\Api\Rongyun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Response;

class Rcloud extends Controller
{
    protected $appKey = '6tnym1br65287';
    protected $appSecret = 'IRcupZlSLMvOIz';
//	protected $jsonPath = "jsonsource/";
    const   SERVERAPIURL = 'http://api.cn.ronghub.com';    //IM服务地址
    const   SMSURL = 'http://api.sms.ronghub.com';          //短信服务地址


    public function __construct(Request $request)
    {

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
    public function getToken(Request $request)
    {
        $userId = $request->get('user_id');
        $name   = $request->get('user_name');
        $portraitUri = $request->get('avatar','');
        try {
            if (empty($userId))
                throw new Exception('用户id必传');

            if (empty($name))
                throw new Exception('用户名必传');

            if (empty($portraitUri))
                throw new Exception('用户头像必传');


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
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
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

