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
        $result = $this->syncData->eventList($per_num);
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
     * 每日分析聊天列表
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
        $access_token = $request->get('access_token');
        if (!$access_token) {
            return $this->res_error('token不存在',1567);
        }
        $token_info = $this->decode_access_token($access_token);
        if (!$token_info) {
            return $this->res_error('token失效',8789);
        }
        $user_info = $token_info[0];
//        开户类型1=>黄金/白银，2=>外汇，3=>股票,4=>期货期权
//        货币类型1=>港币,2=>美元
        $data = [
            'type' => $request->get('type', 2),
            'currency_type' => $request->get('currency_type', 2),
            'name_cn' => trim($request->get('name_cn')),
            'name_en' => trim($request->get('name_en')),
            'phone' => trim($request->get('phone')),
            'email' => trim($request->get('email')),
            'qq' => intval($request->get('qq'), 0),
            'message' => $request->get('message', '无'),
            'user_id' => $user_info['id'],
            'user_name' =>  $user_info['name'],
        ];
        if (!$data['phone']) {
            return response()->error(1314, 'Phone Required');
        }
        if (!$data['name_cn']) {
            return response()->error(1413, 'CN Name Required');
        }
        if (!$data['name_en']) {
            return response()->error(3344, 'EN Name Required');
        }
        if (!$data['email']) {
            return response()->error(4131, 'Email Required');
        }
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
        $member_info['is_post'] = MembersModel::find($member_info['member_id'])->is_post;
        if($member_info['is_post'] ==0){
            return $this->res_error('没有登录或者没有发帖权限',4004);
        }
        if($member_info['is_post'] ==1){
            return $this->res_error('发帖权限正在申请中',4004);
        }

        //走中间介判断是否有发布的权限
        $data = [
            'product_type' => intval($request->get('product_type', 1)),
            'action' => intval($request->get('action', 1)),
            'from_price' => intval($request->get('from_price', 0)),
            'to_price' => intval($request->get('to_price', 99)),
            'date' => intval($request->get('date')),
            'time' => trim($request->get('time', '12:00')),
            'stop_loss' => intval($request->get('stop_loss', 99)),
            'target' => intval($request->get('target', 99)),
            'comment' => trim($request->get('comment')),
            'create_user_id'=>$member_info['member_id'],
            'create_user_name'=>$member_info['member_name']
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
        $per_num = $request->has('per_num') ? intval($request->get('per_num')) : 10;
        $result = $this->syncData->aceList($per_num);
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

}
