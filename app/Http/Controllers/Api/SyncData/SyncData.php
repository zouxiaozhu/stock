<?php

namespace App\Http\Controllers\Api\SyncData;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
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


}
