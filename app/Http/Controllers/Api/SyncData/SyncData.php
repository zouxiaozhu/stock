<?php

namespace App\Http\Controllers\Api\SyncData;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;


class SyncData extends Controller
{
    protected $syncData;

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
            'per_num'   =>  $request->has('per_num') ? intval($request->get('per_num')) : 10
        ];
        if ($request->has('date')) {
            $data['date'] = $request->get('date');
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
            'type'  => $type,
            'lang'  => $lang,
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
            'type'  => $type,
            'lang'  => $lang,
            'id'    => $id,
        ];
        $result = $this->syncData->analyDetail($data);
        return $result;
    }

    /**
     * 开户登记
     * @param Request $request
     * @return mixed
     */
    public function accountRegist(Request $request)
    {
//        开户类型1=>黄金/白银，2=>外汇，3=>股票,4=>期货期权
//        货币类型1=>港币,2=>美元
        $data = [
            'type'          =>  $request->get('type', 2),
            'currency_type' =>  $request->get('currency_type', 2),
            'name_cn'       =>  trim($request->get('name_cn')),
            'name_en'       =>  trim($request->get('name_en')),
            'phone'         =>  trim($request->get('phone')),
            'email'         =>  trim($request->get('email')),
            'qq'            =>  intval($request->get('qq'), 0),
            'message'       =>  $request->get('message', '无'),
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
            $check_result =  strlen($email) > 6 && strlen($email) <= 128 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
            if (!$check_result) {
                return response()->error(4433, 'Email Format Error');
            }
        }
        $result = $this->syncData->accountRegist($data);
        return $result;
    }

}
