<?php

/**
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/13
 * Time: 下午7:44
 */
namespace App\Repositories\ImplementsResp;

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
            ->select('content.content', 'event.event_date', 'event.title')
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
            ->select('news_id', 'title', 'publish_date_time')
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
            ->select('content.content', 'news.title', 'news.publish_date_time')
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
        $data_arr['data'] = $data;
        return response()->success($data_arr);
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
            ->select('content.content', 'news.headline', 'news.publish_date_time')
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
            ->select('monthly', 'weekly', 'daily', 'update_date')
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();
        $data = obj2Arr($data);
        $data = isset($data[0]) ? $data[0] : [];
        if (!empty($data)) {
            $data['monthly'] = unserialize($data['monthly']);
            $data['weekly']  = unserialize($data['weekly']);
            $data['daily']   = unserialize($data['daily']);
            $data['update_date'] = $data['update_date'];
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
            ->select('res1', 'res2', 'res3', 'res4', 'sup1', 'sup2', 'sup3', 'sup4', 'update_date')
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();
        $data = obj2Arr($data);
        $data = isset($data[0]) ? $data[0] : [];
        if (!empty($data)) {
            foreach ($data as $k => &$v) {
                if ($k != 'update_date') {
                    $v = unserialize($v);
                }
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
        if (isset($params['start_time'])) {
            $data->where('date', '>', $params['start_time']);
        }

        if (isset($params['end_time'])) {
            $data->where('date', '<', $params['end_time']);
        }

        if (isset($params['country'])) {
            $data->where('country', '=', $params['country']);
        }
        $data = $data->paginate($params['per_num']);
        $data = obj2Arr($data);
        $econ_data = $data['data'];
//        if (!empty($econ_data)) {
//            foreach ($econ_data as $k => &$v) {
//                $v['quarter']  = unserialize($v['quarter']);
//                $v['forecast'] = unserialize($v['forecast']);
//                $v['lasttime'] = unserialize($v['lasttime']);
//            }
//        }
        $data['data'] = $econ_data;
        return response()->success($data);
    }

    /**
     * 每日分析标题列表
     * @param $data
     * @return mixed
     */
    public function analyList($data)
    {
        $res = DB::table('analy')
            ->select('id', 'title', 'date')
            ->where('type', $data['type'])
            ->where('lang', $data['lang'])
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();
        $result = obj2Arr($res);
        if (!empty($result)) {
            foreach ($result as $k => &$v) {
                $v['title'] = unserialize($v['title']);
            }
        }
        return response()->success($result);
    }

    /**
     * 每日分析详情
     * @param $data
     * @return mixed
     */
    public function analyDetail($data)
    {
        $res = DB::table('analy')
            ->select('title', 'date', 'content')
            ->where('id', $data['id'])
            ->where('type', $data['type'])
            ->where('lang', $data['lang'])
            ->take(1)
            ->get();
        return response()->success($res);
    }

    /**
     * 开户登记
     * @param $data
     * @return mixed
     */
    public function accountRegist($data)
    {
        $verify_params = [
            'email' =>  $data['email'],
            'phone' =>  $data['phone'],
        ];
        $verify_res = $this->_verifyExist($verify_params);
        if (!$verify_res) {
            return response()->error(9527, 'Account Exist');
        }
        $res = DB::table('account_regist')->insert($data);
        return response()->success('success');
    }

    /**
     * 验证注册账户是否已经存在
     * @param $params
     * @return bool
     */
    private function _verifyExist($params)
    {
        $res = DB::table('account_regist')
            ->select('id')
            ->where('phone', $params['phone'])
            ->orWhere('email', $params['email'])
            ->take(1)
            ->get();
        return $res ? false : true;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function fileUpload($data)
    {
//        var_export($data);die;
        $res = DB::table('file_upload')->insert($data);
        return response()->success($res);
    }

    /**
     * 发布谁是高手信息
     * @param $data
     * @return mixed
     */
    public function aceCreate($data)
    {
        //测试数据,暂时写死,后期读取客户信息
        $data['time'] = time();
        $data['avatar'] = 'http://img.team.cloud.hoge.cn/material/tuji/img/2017/12/201712201640464Ls0.jpg';
        $res = DB::table('ace')->insert($data);
        if ($res) {
            return response()->success('success');
        } else {
            return response()->error(9527, 'Create Failed');
        }
    }

    /**
     * 谁是高手列表展示
     * @param $per_num
     * @return mixed
     */
    public function aceList($per_num)
    {
        $list = DB::table('ace')
            ->select('id', 'product_type', 'to_price', 'action', 'stop_loss')
            ->orderBy('create_time', 'DESC')
            ->paginate($per_num);
        return response()->success($list);
    }


    /**
     * 谁是高手详情
     * @param $id
     * @return mixed
     */
    public function aceDetail($id)
    {
        $data = DB::table('ace')
            ->select('*')
            ->where('id', $id)
            ->get();
        return response()->success($data);
    }

    /**
     * 谁是高手相关阅读
     * @param $id
     * @return mixed
     */
    public function relatedAce($id)
    {
        $list = DB::table('ace')
            ->select('id', 'product_type', 'to_price', 'action', 'stop_loss')
            ->where('id', '>', $id)
            ->take(2)
            ->get();
        return response()->success($list);
    }

    /**
     * 谁是高手更新评论数
     * @param $id
     * @return mixed
     */
    public function updateAceCommentNum($id)
    {
        $res = DB::table('ace')
            ->where('id', $id)
            ->increment('comment_num', 1);
        return response()->success('success');
    }
}