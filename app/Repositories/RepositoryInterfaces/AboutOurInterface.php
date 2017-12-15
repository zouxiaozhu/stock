<?php
/**
 * Email: shengyulong@hoge.cn
 * Link: www.hoge.cn
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/15
 * Time: 上午12:38
 */

namespace App\Repositories\RepositoryInterfaces;


interface AboutOurInterface
{
    /**
     * 添加公司信息
     * @param $data
     * @return mixed
     */
    public function insert($data);

    /**
     * 更新公司信息
     * @param $data
     * @return mixed
     */
    public function update($data);

    /**
     * 详情展示
     * @return mixed
     */
    public function show();

    /**
     * 删除联系我们
     * @param $id
     * @return mixed
     */
    public function delete($id);
}