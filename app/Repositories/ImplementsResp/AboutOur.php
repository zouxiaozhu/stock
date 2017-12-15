<?php
/**
 * Email: shengyulong@hoge.cn
 * Link: www.hoge.cn
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/15
 * Time: 上午12:39
 */

namespace App\Repositories\ImplementsResp;

use DB;
use App\Repositories\RepositoryInterfaces\AboutOurInterface;

class AboutOur implements AboutOurInterface
{

    /**
     * 添加联系我们
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        $res = DB::table('about_our')->insert($data);
        return response()->success('success');
    }

    /**
     * 更新联系我们
     * @param $data
     * @return mixed
     */
    public function update($data)
    {
        if (isset($data['corporate_name'])) {
            $update_data['corporate_name'] = $data['corporate'];
        }
        if (isset($data['introduce'])) {
            $update_data['introduce'] = $data['introduce'];
        }
        $res = DB::table('about_our')
            ->where('id', $data['id'])
            ->update($update_data);
        return  response()->success('success');
    }

    /**
     * @return mixed
     */
    public function show()
    {
        $res = DB::table('about_our')
            ->select('corporate_name', 'id', 'introduce')
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();
        return response()->success($res);

    }

    /**
     * 删除联系我们
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $res = DB::table('about_our')->where('id', $id)->delete();
        return $res ? response()->success('success') : response()->error('3344', 'Delete Failed');
    }
}