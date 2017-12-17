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


}
