<?php
/**
 * Email: shengyulong@hoge.cn
 * Link: www.hoge.cn
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/23
 * Time: 下午1:04
 */

namespace App\Repositories\RepositoryInterfaces;

interface openFormInterface
{
    /**
     * 后台创建下载地址
     * @param $data
     * @return mixed
     */
    public function create($data);
}