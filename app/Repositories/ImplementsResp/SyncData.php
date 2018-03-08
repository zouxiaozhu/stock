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
use Illuminate\Pagination\Paginator;

class SyncData implements SyncDataInterface
{
    /**
     * 财经日志列表
     * @params $per_num 每页数量
     * @return mixed
     */
    public function eventList($per_num, $status)
    {
        $current_time = time();
        $data = DB::table('event')
            ->leftJoin('content', 'event.event_id', '=', 'content.content_id')
            ->select('event.event_id', 'event.event_date', 'event.title', 'content.content')
            ->where('content.type', '=', 1);
        //已发布
        if ($status == 1) {
            $data->where('event.event_date', '<', $current_time);
        }
        //即将发布
        if ($status ==2) {
            $data->where('event.event_date', '>', $current_time);
        }
        $data= $data->orderBy('event.event_date', 'desc')
            ->paginate($per_num);
        $data = json_decode(json_encode($data), true);
        $list_data = $data['data'];
        if (empty($list_data)) {
            return response()->success([]);
        }
//        var_export($data);die;
        foreach ($list_data as $k => &$v) {
            $v['content'] = strip_tags($v['content']);
        }
        $data['data'] = $list_data;
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
    public function newsList($per_num, $category)
    {
        $data = DB::table('news')
            ->select('news_id', 'title', 'publish_date_time', 'category', 'image_link')
            ->where('type', 1);
        //分类 $category 1:贵金属,2:外汇3:股票4:期货5:路透社
        //贵金属
        $gjs = ['貴金屬', '黄金', '白銀'];
        $waihui = ['瑞郎', '歐元', '英鎊', '加元', '紐元', '澳元', '日圓', '美元'];
        $gupiao = ['中國', '中國股市', '港股','美股'];
        $qihuo = ['能源/石油期貨', '農產品期貨', ];
        $lutoushe = array_merge($gjs, $waihui, $gupiao, $qihuo);
        switch ($category) {
            case 1:
                $data = $data->whereIn('category', $gjs);
                break;
            case 2:
                $data = $data->whereIn('category', $waihui);
                break;
            case 3 :
                $data = $data->whereIn('category', $gupiao);
                break;
            case 4:
                $data = $data->whereIn('category', $qihuo);
                break;
            default :
                $data = $data->whereNotIn('category', $lutoushe);
                break;
        }
        $data = $data->orderBy('publish_date_time', 'desc')
            ->paginate($per_num);
        $data_arr = obj2Arr($data);
        $list_data = $data_arr['data'];
//        var_export($list_data);die;
        if (!empty($list_data)) {
            foreach ($list_data as $k => &$v) {
                $comment_nums = DB::table('comments')
                    ->where('post_id', $v['news_id'])
                    ->where('type', 2)
                    ->count();
                $v['comment_num'] = $comment_nums;
                $v['image_link'] = empty(unserialize($v['image_link'])) ? '' : unserialize($v['image_link']);
            }
        }
        $data_arr['data'] = $list_data;
        return response()->success($data_arr);
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
            ->select('content.content', 'news.title', 'news.publish_date_time', 'news.image_link')
            ->where('news.news_id', $id)
            ->where('content.type', 2)
            ->take(1)
            ->get();
        $data = isset($data[0]) ? $data[0] : [];
        $comment_num = DB::table('comments')
            ->where('post_id', $id)
            ->where('type', 2)
            ->count();
        $like_num = DB::table('like')
            ->where('post_id', $id)
            ->where('type', 2)
            ->count();
        $data->comment_num = $comment_num;
        $data->like_num = $like_num;
        $data->image_link = unserialize($data->image_link);
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
            ->leftJoin('content', 'news.news_id', '=', 'content.content_id')
            ->select('content.content', 'news.headline', 'news.publish_date_time', 'news.news_id')
            ->where('news.type', 2)
            ->orderBy('news.publish_date_time', 'desc')
            ->paginate($per_num);
        $data_arr = obj2Arr($data);
        $data = $data_arr['data'];
        if (empty($data)) {
            return response()->success([]);
        }
        foreach ($data as $k => &$v) {
            $v['headline'] = unserialize($v['headline']);
            $v['content'] = strip_tags($v['content']);
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
//            ->select('content.content', 'news.headline', 'news.publish_date_time')
            ->select('content.content',  'news.publish_date_time')
            ->where('news.news_id', $id)
            ->where('content.type', 3)
            ->take(1)
            ->get();
        $data = isset($data[0]) ? $data[0] : [];
        $data->content = strip_tags($data->content);
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
            ->first();
        $new_data = [
            '伦敦黄金'  =>  (string)$data->xau,
            '伦敦白银'  =>  (string)$data->xag,
            '欧元'     =>  (string)$data->eur,
            '日元'     =>  (string)$data->jpy,
            '英镑'     =>  (string)$data->gbp,
            '瑞郎'     =>  (string)$data->chf,
            '澳元'     =>  (string)$data->aud,
            '纽元'     =>  (string)$data->nzd,
            '加元'     =>  (string)$data->cad,
        ];
        return response()->success($new_data);
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
            ->select('*')
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
                $v['title'] = empty(unserialize($v['title'])) ? '每日分析(Analyse EveryDay)' : unserialize($v['title']);
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
        if ($data['id'] == 0) {
            $res = DB::table('analy')
                ->select('title', 'date', 'content')
                ->orderBy('date', 'desc')
                ->first();
        } else {
            $res = DB::table('analy')
                ->select('title', 'date', 'content')
                ->where('id', $data['id'])
                ->where('type', $data['type'])
                ->where('lang', $data['lang'])
                ->take(1)
                ->get();
        }
        $res = obj2Arr($res);
        $res = $res[0];
        $res['title'] = unserialize($res['title']);
        return response()->success($res);
    }

    /**
     * 开户登记
     * @param $data
     * @return mixed
     */
    public function accountRegist($data)
    {
//        $verify_params = [
//            'email' =>  $data['email'],
//            'phone' =>  $data['phone'],
//        ];
//        $verify_res = $this->_verifyExist($verify_params);
//        if (!$verify_res) {
//            return response()->error(9527, 'Account Exist');
//        }
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
    public function aceList($data)
    {
        $list = DB::table('ace')
            ->select('id', 'product_type', 'to_price', 'action', 'stop_loss', 'avatar', 'create_user_name','create_time', 'date','time');
        if (isset($data['type'])) {
            $list = $list->where('product_type','like', '%'.$data['type'].'%' );
        }
        if (isset($data['is_my'])) {
            $list = $list->where('create_user_id', $data['member_id'])
                ->orderBy('create_time', 'DESC')
                ->paginate($data['per_num']);
            return response()->success($list);
        }
        $list = $list->where('rule_result',1)
            ->orderBy('create_time', 'DESC')
            ->paginate($data['per_num']);
//        var_export($list);die;
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
        $data = obj2Arr($data);
        $data = $data[0];
        $comment_num = DB::table('comments')
            ->where('post_id', $id)
            ->where('type', 0)
            ->count();
        $like_num = DB::table('like')
            ->where('post_id', $id)
            ->where('type', 0)
            ->count();
        $data['comment_num'] = $comment_num;
        $data['like_num'] = $like_num;
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
            ->select('id', 'product_type', 'to_price', 'action', 'stop_loss','avatar','create_user_name')
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

    /**
     * 模拟账户创建
     * @param $data
     * @return mixed
     */
    public function analogCreate($data)
    {
        $exist_result = DB::table('analog')->select('id')->where('phone', $data['phone'])->first();
        if (!empty($exist_result)) {
            return response()->error(9527, 'Account Exist');
        }
        $res = DB::table('analog')->insert($data);
        if ($res) {
            return response()->success('success');
        } else {
            return response()->error(9527, 'Create Failed');
        }
    }

    /**
     * 全屏报价
     * @return mixed
     */
    public function screenPrice($data)
    {
        $res = DB::table('screen_price')
            ->select('*');
        if (isset($data['type'])) {
            $res = $res->whereIn('type', explode(',', $data['type']));
        }
        $res = $res->get();
        $res = json_decode(json_encode($res), true);
        if ($data['show_type'] == 1) {
            foreach ($res as $k => $v) {
                if ($v['now'] != 'TT') {
                    $now = explode('/', $v['now']);
                    $res[$k]['sale'] = $now[0];
                    $res[$k]['buy']  = substr($now[0], 0,-2).$now[1];
                    $today_sale = explode('/', $v['today'])[0];
                    $today_buy  = explode('/', $v['today'])[1];
                    $res[$k]['sale_sign'] = $res[$k]['sale'] >= $today_sale ? 'up' : 'down';
                    $res[$k]['buy_sign']  = $res[$k]['buy']  >= $today_buy  ? 'up' : 'down';
                    $res[$k]['time'] = date('Y-m-d H:i:s', $res[$k]['time'] / 1000);
                } else {
                    $res[$k]['tmp_name'] = 'TT';
                }
            }
        } else {
            foreach ($res as $k => $v) {
                if ($v['now'] != 'TT') {
                    $res[$k]['time'] = date('Y-m-d H:i:s', $res[$k]['time'] / 1000);
                } else {
                    $res[$k]['tmp_name'] = 'TT';
                }
            }
        }
        return response()->success($res);
    }

    /**
     * 设置到价提示
     * @param $data
     * @return mixed
     */
    public function setPriceNotice($data)
    {
        $result = DB::table('set_price_notice')
            ->insert($data);
        return response()->success('success');
    }

    /**
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updatePriceNotice($data, $id)
    {
        $result = DB::table('set_price_notice')
            ->where('id', $id)
            ->update($data);
        if (!$result) {
            return response()->false(9527, '更新失败');
        }
        return response()->success('更新成功');
    }

    /**
     * 我得到价提示
     * @param $member_id
     * @return mixed
     */
    public function myPriceNotice($member_id)
    {
        $result = DB::table('set_price_notice')
            ->select('id', 'product', 'forewarn', 'cvm')
            ->where('create_user_id', $member_id)
            ->orderBy('update_time', 'DESC')
            ->get();
//        var_export($result);die;
        if (!empty($result)) {
            foreach ($result as &$v) {
                $v->id = (string)($v->id);
                $v->product = (string)($v->product);
                $v->forewarn = (string)($v->forewarn);
            }
        }
        return response()->success($result);
    }

    /**
     * 删除到价提示
     * @param $id
     * @return mixed
     */
    public function delPriceNotice($id)
    {
        $result = DB::table('set_price_notice')
            ->where('id', $id)
            ->delete();
//        var_export($result);die;
        if (!$result) {
            return response()->false(9527, '删除失败');
        }
        return response()->success('删除成功');
    }

    /**
     * app端巡通知价格提示
     * @param $member_id
     * @return mixed
     */
    public function appPriceNotice($member_id)
    {
        //1.查询用户的到价提示
        $member_set = DB::table('set_price_notice')
            ->select('cvm', 'product')
            ->where('create_user_id', $member_id)
            ->get();
        if (empty($member_set)) {
            return response()->false(9876, '没有通知');
        }
        $member_set = json_decode(json_encode($member_set), true);
//        var_export($member_set);die;
        $type = array_column($member_set, 'product');
//        var_export($type);die;
        //2.获取报价
        $screen_price = DB::table('screen_price')
            ->select('now', 'type')
            ->whereIn('type', $type)
            ->get();
        $screen_price = json_decode(json_encode($screen_price), true);
        $tmp = [];
        foreach ($screen_price as $k => $v) {
            $price = explode('/', $v['now']);
//            $screen_price[$k]['price'] = $price[0];
            $tmp[$v['type']] = $price[0];
        }

        $notice_array = [];  //通知的数据
        $del_array = [];   //通知后删除到价提示设置
        foreach ($member_set as $k => $v) {
//            echo $v['product'];die;
//            var_export($tmp[$v['product']]);die;
            if ((float)$v['cvm'] <= (float)$tmp[$v['product']] && $tmp[$v['product']] != '--') {
                $product_name = $this->_getProductName($v['product']);
                $notice_array[] = $product_name . '已达到您设置的监控值 '. $v['cvm'] . ' 请及时查看';
                $del_array[] = $v['product'];
            }
        }
        DB::table('set_price_notice')
            ->whereIn('product', $del_array)
            ->where('create_user_id', $member_id)
            ->delete();
        return response()->success($notice_array);
    }

    /**
     * 获取类型名
     * @param $type
     * @return string
     */
    private function _getProductName($type)
    {
        switch ($type) {
            case 1 :
                $name = '欧元';
                break;
            case 2 :
                $name = '日元';
                break;
            case 3 :
                $name = '英镑';
                break;
            case 4 :
                $name = '瑞郎';
                break;
            case 5 :
                $name = '澳元';
                break;
            case 6 :
                $name = '纽元';
                break;
            case 7 :
                $name = '加元';
                break;
            case 8 :
                $name = '欧日';
                break;
            case 9 :
                $name = '欧瑞';
                break;
            case 10 :
                $name = '欧英';
                break;
            case 11 :
                $name = '瑞日';
                break;
            case 12 :
                $name = '澳日';
                break;
            case 13 :
                $name = '港金';
                break;
            case 14 :
                $name = '黄金';
                break;
            case 15 :
                $name = '白银';
                break;
            default :
                $name = '港敦';
                break;

        }
        return $name;
    }
}