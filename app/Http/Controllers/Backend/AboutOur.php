<?php
/**
 * Email: shengyulong@hoge.cn
 * Link: www.hoge.cn
 * Created by PhpStorm.
 * User: shengyulong
 * Date: 2017/12/15
 * Time: 上午12:27
 */

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\RepositoryInterfaces\AboutOurInterface;


class AboutOur extends Controller
{
    protected $about;
    /**
     * AboutOur constructor.
     */
    public function __construct(AboutOurInterface $about)
    {
        $this->about = $about;
    }


    /**
     * 添加联系我们
     * @param Request $request
     * @return mixed
     */
    public function insert(Request $request)
    {
        $data = [
            'corporate_name'    =>  trim($request->get('corporate_name')),
            'introduce'         =>  trim($request->get('introduce')),
        ];

        if (!$data['corporate_name']) {
            return response()->error(1314, 'Corporate Name Required');
        }

        if (!$data['introduce']) {
            return response()->error(1413, 'Corporate introduce Required');
        }

        $result = $this->about->insert($data);
        return $result;
    }

    /**
     * 更新联系我们
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $data['id'] = $id;
        if ($request->has('corporate_name')) {
            $data['corporate_name'] = trim($request->get('corporate_name'));
        }
        if ($request->has('introduce')) {
            $data['introduce'] = trim($request->get('introduce'));
        }

        $result = $this->about->update($data);
        return $result;
    }

    /**
     * 查询联系我们
     */
    public function show()
    {
        $result = $this->about->show();
        return $result;
    }

    /**
     * 删除联系我们
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $result = $this->about->delete($id);
        return $result;
    }
}