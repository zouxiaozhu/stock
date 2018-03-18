<?php

namespace App\Http\Controllers\Backend;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\RepositoryInterfaces\openFormInterface;

class openForm extends Controller
{
    //
    protected $open;

    public function __construct(openFormInterface $open)
    {
        $this->open = $open;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function openList(Request $request)
    {
        $per_num = intval($request->get('per_num', 20));
        $res = DB::table('open_form')
            ->select('title_en', 'title_cn', 'pdf_url', 'jpg_url')
            ->orderBy('id', 'DESC')
            ->paginate($per_num);
        return $res;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
//        1=>英皇金业,2=>英皇证券,3=>英皇期货
        $data = [
            'title_en'  =>  trim($request->get('title_en')),
            'title_cn'  =>  trim($request->get('title_cn')),
            'pdf_url'   =>  trim($request->get('pdf_url')),
            'jpg_url'   =>  trim($request->get('jpg_url')),
            'type'      =>  intval($request->get('type', 1)),
        ];
        if (!$data['title_en']) {
            responser()->error(1314, 'En Tiele Required');
        }
        if (!$data['title_cn']) {
            responser()->error(1413, 'Cn Tiele Required');
        }
        if (!$data['pdf_url']) {
            responser()->error(3344, 'PDF Url Required');
        }
        if (!$data['jpg_url']) {
            responser()->error(4433, 'JPG Url Required');
        }
        $res = $this->open->create($data);
        return $res;
    }


    /**
     * @param Request $resquest
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $data = [];
        if ($request->has('title_en')) {
            $data['title_en'] = trim($request->get('title_en', ''));
        }
        if ($request->has('title_cn')) {
            $data['title_cn'] = trim($request->get('title_cn', ''));
        }
        if ($request->has('pdf_url')) {
            $data['pdf_url'] = trim($request->get('pdf_url', ''));
        }
        if ($request->has('jpg_url')) {
            $data['jpg_url'] = trim($request->get('jpg_url', ''));
        }
        if ($request->has('type')) {
            $data['type'] = intval($request->get('type', 1));
        }
        if (!empty($data)) {
            $res = DB::table('open_form')->where('id', $id)->update($data);
            return $res ? response()->success('success') : response()->error(1234, 'Update Failed');
        } else {
            return response()->error(1432, 'NO Update Info');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function openDelete(Request $request, $id)
    {
        $res = DB::table('open_form')
            ->where('id', $id)
            ->delete();
        return $res ? response()->success('success') : response()->error(1514, 'Delete Failed');
    }


}
