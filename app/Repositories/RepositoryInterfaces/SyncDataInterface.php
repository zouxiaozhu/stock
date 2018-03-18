<?php

/**
 * Email: shengyulong@hoge.cn
 * Link: www.hoge.cn
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/13
 * Time: 下午7:33
 */
namespace App\Repositories\RepositoryInterfaces;


interface SyncDataInterface
{
    /**
     * 财经日志列表
     * @param $per_num 每页数量
     * @return mixed
     */
    public function eventList($per_num, $status);


    /**
     * 财经日志详情
     * @param $id
     * @return mixed
     */
    public function eventDetail($id);

    /**
     * 财经新闻列表
     * @param $per_num  每页数量
     * @return mixed
     */
    public function newsList($per_num, $category);

    /**
     * 财经新闻详情
     * @param $id
     * @return mixed
     */
    public function newsDetail($id);

    /**
     * 公告列表
     * @param $per_num
     * @return mixed
     */
    public function noticeList($per_num);

    /**
     * 公告详情
     * @param $id
     * @return mixed
     */
    public function noticeDetail($id);

    /**
     * app首页展示,汇海强弱指数图
     * @return mixed
     */
    public function strongWeakGraph();

    /**
     * app首页展示,汇海强弱指数图(安卓)
     * @return mixed
     */
    public function strongWeakGraphEn();

    /**
     * 贵金属价位参考
     * @return mixed
     */
    public function refBullion();


    /**
     * 外汇价位参考
     * @return mixed
     */
    public function refForex();

    /**
     * 经济数据
     * @param $data
     * @return mixed
     */
    public function econList($data);

    /**
     * 每日分析标题列表
     * @param $data
     * @return mixed
     */
    public function analyList($data);


    /**
     * 每日分析详情
     * @param $data
     * @return mixed
     */
    public function analyDetail($data);

    /**
     * 开户登记
     * @param $data
     * @return mixed
     */
    public function accountRegist($data);

    /**
     * 文件上传
     * @param $data
     * @return mixed
     */
    public function fileUpload($data);

    /**
     * 发布谁是高手信息
     * @param $data
     * @return mixed
     */
    public function aceCreate($data);

    /**
     * 谁是高手展示列表
     * @param $per_num
     * @return mixed
     */
    public function aceList($data);

    /**
     * 谁是高手详情
     * @param $id
     * @return mixed
     */
    public function aceDetail($id);

    /**
     * 谁是高手相关阅读
     * @param $id
     * @return mixed
     */
    public function relatedAce($id);

    /**
     * 谁是高手更新评论数
     * @param $id
     * @return mixed
     */
    public function updateAceCommentNum($id);

    /**
     * 模拟账号创建
     * @param $data
     * @return mixed
     */
    public function analogCreate($data);

    /**
     * 全屏报价
     * @return mixed
     */
    public function screenPrice($data);

    /**
     * 设置报价提示
     * @param $data
     * @return mixed
     */
    public function setPriceNotice($data);

    /**
     * 更新到价提示
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updatePriceNotice($data, $id);


    /**
     * 我得到价提示
     * @param $member_id
     * @return mixed
     */
    public function myPriceNotice($member_id);

    /**
     * 删除到价提示
     * @param $id
     * @return mixed
     */
    public function delPriceNotice($id);

    /**
     * app端巡通知价格提示
     * @return mixed
     */
    public function appPriceNotice($member_id);
}