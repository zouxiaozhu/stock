<?php
/**
 * Email: shengyulong@hoge.cn
 * Link: www.hoge.cn
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/23
 * Time: 下午1:06
 */

namespace App\Repositories\ImplementsResp;

use DB;
use App\Repositories\RepositoryInterfaces\openFormInterface;
class openForm implements openFormInterface
{
    public function create($data)
    {
        $result = DB::table('open_form')->insert($data);
        return $result ? response()->success($result) : response()->error(9527, 'Create Failed');
    }
}