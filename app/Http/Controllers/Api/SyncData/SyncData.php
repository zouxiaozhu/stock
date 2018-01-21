<?php

namespace App\Http\Controllers\Api\SyncData;

use App\Http\Controllers\ApiAuth\ApiAuthTrait;
use App\Http\Controllers\Backend\AdminTrait;
use App\Http\Models\Backend\MembersModel;
use App\Http\Models\Backend\TerminalSettings;
use App\Http\Models\Backend\Users;
use App\User;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;
use DB;
use App\Http\Controllers\Api\SyncData\Smtp;


class SyncData extends Controller
{
    use ApiAuthTrait;
    protected $syncData;
    protected $access_token;
    protected $file_type = ['jpg', 'jpeg', 'png', 'bmp'];

    public function __construct(Request $request, SyncDataInterface $sync)
    {
        $this->syncData = $sync;
    }

    /**
     * 财经日志数据
     * @param Request $request
     * @return mixed
     */
    public function eventList(Request $request)
    {
        $per_num = $request->has('per_num') ? intval($request->get('per_num')) : 10;
        //1已发布,2待发布
        $publish_status = $request->has('status') ? intval($request->get('status')) : 1;
        $result = $this->syncData->eventList($per_num, $publish_status);
        return $result;
    }

    /**
     * 财经日志详情
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function eventDetail(Request $request, $id)
    {
        $result = $this->syncData->eventDetail($id);
        return $result;
    }

    /**
     * 财经新闻数据列表
     * @param Request $request
     * @return mixed
     */
    public function newsList(Request $request)
    {
        $per_num = $request->has('per_num') ? intval($request->get('per_num')) : 10;
        $result = $this->syncData->newsList($per_num);
        return $result;
    }

    /**
     * 财经新闻详情
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function newsDetail(Request $request, $id)
    {
        $result = $this->syncData->newsDetail($id);
        return $result;
    }

    /**
     * 公告列表
     * @param Request $request
     * @return mixed
     */
    public function noticeList(Request $request)
    {
        $per_num = $request->has('per_num') ? intval($request->get('per_num')) : 10;
        $result = $this->syncData->noticeList($per_num);
        return $result;
    }

    /**
     * 公告详情
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function noticeDetail(Request $request, $id)
    {
        $result = $this->syncData->noticeDetail($id);
        return $result;
    }

    /**
     * app首页展示,汇海强弱指数图
     * @return mixed
     */
    public function strongWeakGraph()
    {
        $result = $this->syncData->strongWeakGraph();
        return $result;
    }


    /**
     * 贵金属价位参考(阻力支持)
     * @return mixed
     */
    public function refBullion()
    {
        $result = $this->syncData->refBullion();
        return $result;
    }


    /**
     * 外汇价位参考
     * @return mixed
     */
    public function refForex()
    {
        $result = $this->syncData->refForex();
        return $result;
    }

    /**
     * 经济数据列表
     * @return mixed
     */
    public function econList(Request $request)
    {
        $data = [
            'per_num' => $request->has('per_num') ? intval($request->get('per_num')) : 10
        ];
        if ($request->has('start_time')) {
            $data['start_time'] = $request->get('start_time');
        }
        if ($request->has('end_time')) {
            $data['end_time'] = $request->get('end_time');
        }
        if ($request->has('country')) {
            $data['country'] = trim($request->get('country'));
        }
        $result = $this->syncData->econList($data);
        return $result;
    }


    /**
     * 每日分析列表
     * @param Request $request
     * @return mixed
     */
    public function analyList(Request $request)
    {
//     1.倫敦黃金,2.倫敦白銀,3.歐元,4.日元,5.英鎊6.端郎,7.澳元,
//     8.紐元,9.加元,10.港股分析,11.昨日市场总结,12.市场焦距
        $type = $request->has('type') ? intval($request->get('type')) : 1;
        //1=>中文,2=>英文
        $lang = $request->has('lang') ? intval($request->get('lang')) : 1;
        $data = [
            'type' => $type,
            'lang' => $lang,
        ];
        $result = $this->syncData->analyList($data);
        return $result;
    }


    /**
     * 每日分析详情
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function analyDetail(Request $request, $id)
    {
//     1.倫敦黃金,2.倫敦白銀,3.歐元,4.日元,5.英鎊6.端郎,7.澳元,
//     8.紐元,9.加元,10.港股分析,11.昨日市场总结,12.市场焦距
        $type = $request->has('type') ? intval($request->get('type')) : 1;
        //1=>中文,2=>英文
        $lang = $request->has('lang') ? intval($request->get('lang')) : 1;
        $data = [
            'type' => $type,
            'lang' => $lang,
            'id' => $id,
        ];
        $result = $this->syncData->analyDetail($data);
//        $result = obj2Arr($result);
        return $result;
    }

    /**
     * 开户登记
     * @param Request $request
     * @return mixed
     */
    public function accountRegist(Request $request)
    {
//        $access_token = $request->get('access_token');
//        if (!$access_token) {
//            return $this->res_error('token不存在',1567);
//        }
//        $token_info = $this->decode_access_token($access_token);
//        if (!$token_info) {
//            return $this->res_error('token失效',8789);
//        }
//        $user_info = $token_info[0];
//        开户类型1=>黄金/白银，2=>外汇，3=>股票,4=>期货期权
//        货币类型1=>港币,2=>美元
        $data = [
            'type' => trim($request->get('type', '2')),
            'currency_type' => $request->get('currency_type', 2),
            'name_cn' => trim($request->get('name_cn')),
//            'name_en' => trim($request->get('name_en')),
            'phone' => trim($request->get('phone')),
            'email' => trim($request->get('email')),
            'qq' => intval($request->get('qq'), 0),
            'message' => $request->get('message', '无'),
//            'user_id' => $user_info['id'],
//            'user_name' =>  $user_info['name'],
        ];
        if (!$data['phone']) {
            return response()->error(1314, 'Phone Required');
        }
        if (!$data['name_cn']) {
            return response()->error(1413, 'CN Name Required');
        }
//        if (!$data['name_en']) {
//            return response()->error(3344, 'EN Name Required');
//        }
//        if (!$data['email']) {
//            return response()->error(4131, 'Email Required');
//        }
        if ($email = $data['email']) {
            $check_result = strlen($email) > 6 && strlen($email) <= 128 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
            if (!$check_result) {
                return response()->error(4433, 'Email Format Error');
            }
        }
        $result = $this->syncData->accountRegist($data);
        return $result;
    }

    /**
     * 文件上传类
     * @param Request $request
     * @return mixed
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('POST')) {
//            var_dump($_FILES);
            $file = $request->file('file');

            //判断文件是否上传成功
            if ($file->isValid()) {
                //获取原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();
                $filename = date('Y-m-d-H-i-S') . '-' . uniqid() . '-' . $ext;
                $bool = Storage::disk('local')->put($filename, file_get_contents($realPath));
                $filePath = storage_path('app') . '/' . $filename;
                if (!$bool) {
                    return response()->error(1314, 'Upload Failed');
                }
                $return = [
                    'path' => $filePath,
                    'mimeType' => $type,
                ];
                return response()->success($return);
            } else {
                return response()->error(1314, 'Upload Failed');
            }
        }
        return response()->error(1413, 'Must Post');
    }


    public function fileUpload(Request $request)
    {
        $data = [
            'nick_name' => trim($request->get('nick_name')),
            'phone' => trim($request->get('phone')),
            'email' => trim($request->get('email')),
            'description' => trim($request->get('description', '无')),
            'file_url' => trim($request->get('file_url'))
        ];
        //号码验证懒得写
        if ($email = $data['email']) {
            $check_result = strlen($email) > 6 && strlen($email) <= 128 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
            if (!$check_result) {
                return response()->error(4433, 'Email Format Error');
            }
        }
        $res = $this->syncData->fileUpload($data);
        return $res;

    }
    use ApiAuthTrait;
    /**
     * 谁是高手发布
     * @param Request $request
     * @return mixed
     */
    public function aceCreate(Request $request)
    {
        $access_token = $request->get('access_token','');
        $member_info = $this->decode_access_token($access_token);

        if(!$member_info){
            return $this->res_error('登录过期，重新登录',4003);
        }

        $this->member_info = $member_info;
        $member_info['is_post'] = MembersModel::find($member_info['id'])->is_post;
//        var_export($member_info);die;
        if($member_info['is_post'] ==0){
            return $this->res_error('没有登录或者没有发帖权限',4004);
        }
        if($member_info['is_post'] ==1){
            return $this->res_error('发帖权限正在申请中',4004);
        }

        $post_setting = TerminalSettings::where('key','post')->get()->toArray();
        $status = $post_setting &&  $post_setting['0']['value'] == 0 ? 1:  2;
        //走中间介判断是否有发布的权限
        $data = [
            'product_type' => intval($request->get('product_type', 1)),
            'action' => intval($request->get('action', 1)),
            'from_price' => trim($request->get('from_price', 0)),
            'to_price' => trim($request->get('to_price', 99)),
            'date' => intval($request->get('date')),
            'time' => trim($request->get('time', '12:00')),
            'stop_loss' => trim($request->get('stop_loss', 99)),
            'target' => trim($request->get('target', 99)),
            'comment' => trim($request->get('comment')),
            'create_user_id'=>$member_info['id'],
            'create_user_name'=>$member_info['name'],
            'rule_result'=>$status,
            'avatar' => $member_info['avatar'],
            'create_time'   =>  time()
        ];

        if (!$data['date']) {
            return response()->error(1314, 'Date Required');
        }
        if (!$data['comment']) {
            return response()->error(1413, 'Comment Required');
        }
        $res = $this->syncData->aceCreate($data);
        return $res;
    }

    public function applyCreateAce(Request $request)
    {
        //登录后才能申请资格
        if (!$request->has('access_token')) {
            return $this->res_error('用户未登录',4004);
        }
        $access_token = trim($request->get('access_token'));
        $member_info  = $this->decode_access_token($access_token);
//        var_export($member_info);die;
        $nick_name = $member_info['name'];
        if ($request->has('nick_name')) {
            $nick_name = trim($request->get('nick_name'));
        }
        if (!$request->has('apply_reason')) {
            return $this->res_error( '请填写申请理由',1314);
        }
        //查找是否已经申请过
        $exist = DB::table('apply_ace')->select('id')->where('member_id', $member_info['id'])->first();
        if ($exist) {
            return response()->success('已经提交过申请');
        }
        $data = [
            'member_id'     =>  $member_info['id'],
            'member_name'   =>  $member_info['name'],
            'apply_reason'  =>  trim($request->get('apply_reason')),
            'create_time'   =>  time()
        ];
        $res = DB::table('apply_ace')->insert($data);
        if ($res) {
            MembersModel::where('id',$member_info['id'])->update(['is_post'=>1]);
            return response()->success('提交申请成功');
        } else {
            return response()->false('提交申请失败',9638);
        }
    }


    /**
     * 谁是高手列表展示
     * @param Request $request
     * @return mixed
     */
    public function aceList(Request $request)
    {
        $data['per_num'] = $request->has('per_num') ? intval($request->get('per_num')) : 10;
        if ($request->has('is_my') && intval($request->get('is_my') == 1) && $request->has('access_token')) {
            $data['is_my'] = 1;
            $member_info  = $this->decode_access_token($request->get('access_token'));
            $data['member_id'] = $member_info['id'];
        }
        if ($request->has('type')) {
            $data['type'] = explode(',', $request->get('type'));
        }
        $result = $this->syncData->aceList($data);
        return $result;
    }

    /**
     * 谁是高手详情
     * @param $id
     * @return mixed
     */
    public function aceDetail($id)
    {
        $detail = $this->syncData->aceDetail($id);
        return $detail;
    }

    /**
     * 谁是高手相关阅读
     * @param $id
     * @return mixed
     */
    public function relatedAce($id)
    {
        $list = $this->syncData->relatedAce($id);
        return $list;
    }

    /**
     * 谁是高手更新评论数
     * @param $id
     * @return mixed
     */
    public function updateAceCommentNum($id)
    {
        $res = $this->syncData->updateAceCommentNum($id);
        return $res;
    }


    public function res_true($data = '')
    {
        echo json_encode(['error_code'=>0,'data'=>$data]);die;
    }

    public function res_error($msg='',$code=400,$status=false)
    {
        echo json_encode(['error_code'=>$code,
                          'status'=>$status,
                          'error_message'=>$msg,
        ]);die;
    }

    public function sendMail(Request $request)
    {
        $smtpserver     = "smtp.126.com";//SMTP服务器
        $smtpserverport = 25;//SMTP服务器端口
        $smtpusermail   = "zouxiaozhu520@126.com";//SMTP服务器的用户邮箱
        $smtpemailto = $request->get('toemail');//发送给谁
        $smtpuser = "zouxiaozhu520@126.com";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
        $smtppass = "zl520025";//SMTP服务器的用户密码
        $mailtitle = $request->get('title');//邮件主题
        $mailcontent = "<h1>".$request->get('content')."</h1>";//邮件内容
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        //************************ 配置信息 ****************************
        $smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
//        var_export($smtp);die;
        $smtp->debug = true;//是否显示发送的调试信息
//        var_export($smtp);die;
        $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

        var_export($state);die;

    }

    /**
     * 全屏报价
     * @param Request $request
     * @return mixed
     */
    public function screenPrice(Request $request)
    {
        //show_type: 1竖屏,2横屏
        $data['show_type'] = intval($request->get('show_type', 1));
        if ($request->has('type')) {
            $data['type'] = intval($request->get('type'));
        }
        $res = $this->syncData->screenPrice($data);
        return $res;
    }

    /**
     * 报价提示设置
     * @param Request $request
     * @return mixed
     */
    public function setPriceNotice(Request $request)
    {
        $access_token = $request->get('access_token');
        $member_info = $this->decode_access_token($access_token);
        if (!$member_info) {
            return $this->res_error('token失效',8789);
        }
        $data = [
            'product'           =>  intval($request->get('product_type', 1)), //产品类型
            'forewarn'          =>  intval($request->get('forewarn', 1)),   //预警条件,1上穿,2下穿
            'cvm'               =>  $request->get('cvm','0.0'),   //监控值
            'create_user_name'  =>  $member_info['name'],
            'create_user_id'    =>  $member_info['id'],
            'create_time'       =>  time(),
            'update_time'       =>  time(),
        ];
        //校验监控值是否在规定范围内,客户端校验
//        $verify = $this->_verify_price($data);
        $res = $this->syncData->setPriceNotice($data);
        return $res;
    }


    /**
     * 更新到价提示
     * @param Request $request
     * @param $id
     */
    public function updatePriceNotice(Request $request, $id)
    {
        $data = [
            'product'           =>  intval($request->get('product_type', 1)), //产品类型
            'forewarn'          =>  intval($request->get('forewarn', 1)),   //预警条件,1上穿,2下穿
            'cvm'               =>  $request->get('cvm'),   //监控值
            'update_time'       =>  time(),
        ];
        $result = $this->syncData->updatePriceNotice($data, $id);
        return $result;
    }

    /**
     * 我的到价提示
     * @param Request $request
     * @return mixed
     */
    public function myPriceNotice(Request $request)
    {
        $access_token = $request->get('access_token');
        $member_info  = $this->decode_access_token($access_token);
        if (!$member_info) {
            return $this->res_error('token失效',8789);
        }
        $member_id    = $member_info['id'];
        $result       = $this->syncData->myPriceNotice($member_id);
        return $result;
    }

    /**
     * 删除到价提示
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function delPriceNotice(Request $request, $id)
    {
        $result = $this->syncData->delPriceNotice($id);
        return $result;
    }

    /**
     * app端巡通知价格提示
     * @param Request $request
     * @return mixed
     */
    public function appPriceNotice(Request $request)
    {
        $access_token = $request->get('access_token');
        $member_info  = $this->decode_access_token($access_token);
        if (!$member_info) {
            return $this->res_error('token失效',8789);
        }
        $member_id    = $member_info['id'];
        $result = $this->syncData->appPriceNotice($member_id);
        return $result;
    }

    /**
     * 模拟账户创建表单
     * @param Request $request
     * @return mixed
     */
    public function analogCreate(Request $request)
    {
//        //登录后才能申请资格
//        if (!$request->has('access_token')) {
//            return response()->false(4004, '用户未登录');
//        }
//        $access_token = trim($request->get('access_token'));
//        $member_info  = $this->decode_access_token($access_token);
//        //1=>英皇金业,2=>英皇证券,3=>英皇期货
        $type = trim($request->get('type', '1'));
        if (!$request->has('phone')) {
            return response()->false(1235, '电话必填');
        }
        if (!$request->has('email')) {
            return response()->false(1236, '邮箱必填');
        }
        if ($email = trim($request->get('email'))) {
            $check_result = strlen($email) > 6 && strlen($email) <= 128 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
            if (!$check_result) {
                return response()->error(4433, 'Email Format Error');
            }
        }
        $data = [
            'type'       =>  $type,
            'member_name'=>  trim($request->get('name')),
            'phone'      =>  trim($request->get('phone')),
            'email'      =>  trim($request->get('email')),
            'address'    =>  trim($request->get('address', '无')),
            'country'    =>  trim($request->get('country', '无')),
            'message'    =>  trim($request->get('message', '无')),
            'create_time'=>  time(),
        ];
        $res = $this->syncData->analogCreate($data);
        return $res;
    }

    public function delTable(Request $request)
    {
        $table_name = $request->get('table_name');
        $sql = 'drop table ' . $table_name;
        DB::statement($sql);
    }
}
