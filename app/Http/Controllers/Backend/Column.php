<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 0:57
 */
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Backend\ColumnModel;
use Carbon\Carbon;

class Column extends Controller{
    public function __construct()
    {
//        $this->middleware();
    }

    public function addColumn(Request $request)
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $column_id = $request->get('column_id', 0);
        if (!$column_id) {
            $column_info = [];
        } else {
            $column_info = ColumnModel::find($column_id)->toArray();
        }
        return view('admin.column.add-column',['column_info'=>$column_info])->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function updateColumn(Request $request)
    {
        $column_id = $request->get('column_id',0);
        $name = $request->get('name');
        $is_show = $request->get('is_show',0);
        $key = $request->get('key','');
        $sort = $request->get('sort',1);

        $time = Carbon::now()->timestamp;

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();

            $upload_image_name = $time . mt_rand(0, 10000) . '.' . $ext;
            $res = $file->move(env('FILE_STORAGE_PATH', ''), $upload_image_name);
            $data['storage_path'] = env('FILE_STORAGE_PATH', '') . '/' . $upload_image_name;
            $pic_url = (env('APP_URL')) . substr($data['storage_path'], 1);
        }
echo
        $pic_url = isset($pic_url)?$pic_url :'';
        $url = $request->get('url','');

        $insert_data = $update_data = [
            'name'=>$name,'is_show'=>$is_show,'key'=>$key,'url_link'=>$url
        ];

        if($column_id){

            if($pic_url){
                $update_data['url'] = $pic_url;
            }
            ColumnModel::where('id',$column_id)->update($update_data);
        }else{
            if($pic_url){
                $insert_data['url'] = $pic_url;
            }

            $column = ColumnModel::create($insert_data);
        }

        return  Redirect::to('admin/index-column');

    }

    public function delColumn(Request $request){

        $id = $request->get('column_id',0);
        $res = ColumnModel::where('id',$id)->delete();
        return  Redirect::to('admin/index-column');
    }

    public function column(Request $request)
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $column_list = ColumnModel::where('id', '>', '0')->
        orderBy('sort', 'asc')->get()->toArray();
        return view('admin.column.index-column', ['column_list' => $column_list])
            ->with(['prms' => $prms, 'roles_info' => $role]);

//        if($id){
//            $column_info = ColumnModel::find(intval($id))->toArray();
//            return Response::success($column_info);
//        }
//
//        $column_list =ColumnModel::where('id','>',0)->orderBy('updated_at','desc')->get()->toArray();
//        return Response::success($column_list);
    }



}