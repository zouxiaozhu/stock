<?php

/**
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/13
 * Time: 下午7:44
 */
namespace App\Repositories\ImplementResp;

use DB;
use App\Repositories\RepositoryInterfaces\SyncDataInterface;

class SyncData implements SyncDataInterface
{
    /**
     * 财经日志列表
     * @params $per_num 每页数量
     * @return mixed
     */
    public function eventList($per_num)
    {
        $current_time = time();
        $data = DB::table('event')
            ->select('event_id', 'event_date', 'title')
            ->where('display_start_time', '<', $current_time)
            ->where('display_end_time', '>', $current_time)
            ->orderBy('event_date', 'desc')
            ->paginate($per_num);
        return response()->success($data);
    }

    /**
     * 财经日志详情
     * @param $id
     * @return mixed
     */
    public function eventDetail($id)
    {
        $data = DB::table('event')
            ->leftJoin('content', 'event.event_id', '=', 'content.content_id')
            ->select('content.content')
            ->where('event.event_id', $id)
            ->where('content.type', 1)
            ->take(1)
            ->get();
        $data = isset($data[0]) ? $data[0] : [];
        return response()->success($data);
    }

    /**
     * @param \App\Repositories\RepositoryInterfaces\每页数量 $per_num
     * @return mixed
     */
    public function newsList($per_num)
    {
        $data = DB::table('news')
            ->select('news_id', 'title')
            ->where('type', 1)
            ->orderBy('publish_date_time', 'desc')
            ->paginate($per_num);
        return response()->success($data);
    }


    /**
     * 财经新闻详情
     * @param $id
     * @return mixed
     */
    public function newsDetail($id)
    {
        $data = DB::table('news')
            ->leftJoin('content', 'news.news_id', '=', 'content.content_id')
            ->select('content.content')
            ->where('news.news_id', $id)
            ->where('content.type', 2)
            ->take(1)
            ->get();
        $data = isset($data[0]) ? $data[0] : [];
        return response()->success($data);
    }

    /**
     * 公告列表
     * @param $per_num
     * @return mixed
     */
    public function noticeList($per_num)
    {
        $data = DB::table('news')
            ->select('news_id', 'headline')
            ->where('type', 2)
            ->orderBy('publish_date_time', 'desc')
            ->paginate($per_num);
        $data_arr = obj2Arr($data);
        $data = $data_arr['data'];
        if (empty($data)) {
            return response()->success([]);
        }
        foreach ($data as $k => &$v) {
            $v['headline'] = unserialize($v['headline']);
        }
        return response()->success($data);
    }


    /**
     * 公告详情
     * @param $id
     * @return mixed
     */
    public function noticeDetail($id)
    {
        $data = DB::table('news')
            ->leftJoin('content', 'news.news_id', '=', 'content.content_id')
            ->select('content.content')
            ->where('news.news_id', $id)
            ->where('content.type', 3)
            ->take(1)
            ->get();
        $data = isset($data[0]) ? $data[0] : [];
        return response()->success($data);
    }

    /**
     * app首页展示,汇海强弱指数图
     * @return mixed
     */
    public function strongWeakGraph()
    {
        //通过主键查询最新一条数据,允许我用一次万恶的select *
        $data = DB::table('relative')
            ->select('*')
            ->orderBy('relative_id', 'desc')
            ->take(1)
            ->get();
        return response()->success($data);
    }

    /**
     * 贵金属价位参考(阻力支持)
     * @return mixed
     */
    public function refBullion()
    {
        $data = DB::table('ref_bullion')
            ->select('monthly', 'weekly', 'daily')
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();
        $data = obj2Arr($data);
        $data = isset($data[0]) ? $data[0] : [];
        if (!empty($data)) {
            $data['monthly'] = unserialize($data['monthly']);
            $data['weekly']  = unserialize($data['weekly']);
            $data['daily']   = unserialize($data['daily']);
        }
        return response()->success($data);
    }

    /**
     * 外汇价位参考
     * @return mixed
     */
    public function refForex()
    {
        $data = DB::table('ref_forex')
            ->select('res1', 'res2', 'res3', 'res4', 'sup1', 'sup2', 'sup3', 'sup4')
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();
        $data = obj2Arr($data);
        $data = isset($data[0]) ? $data[0] : [];
        if (!empty($data)) {
            foreach ($data as $k => &$v) {
                $v = unserialize($v);
            }
        }
        return response()->success($data);
    }

    /**
     * 经济数据列表
     * @param $params
     * @return mixed
     */
    public function econList($params)
    {
        $data = DB::table('econ')
            ->select('date', 'hktime', 'country', 'fname', 'quarter', 'forecast', 'lasttime')
            ->orderBy('date', 'desc');
        if (isset($params['date'])) {
            $data->where('date', $params['date']);
        }
        $data = $data->paginate($params['per_num']);
        $data = obj2Arr($data);
        $econ_data = $data['data'];
        if (!empty($econ_data)) {
            foreach ($econ_data as $k => &$v) {
                $v['quarter']  = unserialize($v['quarter']);
                $v['forecast'] = unserialize($v['forecast']);
                $v['lasttime'] = unserialize($v['lasttime']);
            }
        }
        $data['data'] = $econ_data;
        return response()->success($data);
    }
}