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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Backend\ColumnModel;
class Column extends Controller{
    public function __construct()
    {

    }

    public function addColumn(Request $request)
    {
        $fill_able = [
            'name' => 'required|max:50|min:2',
        ];

        $message = [
            'name.required' => 'column name Required',
        ];

        $validator = Validator::make($request->all(), $fill_able, $message);
        if ($validator->fails()) {
            return Response::false(1115,$validator->errors()->first());
        }

        $data['name'] = $request->get('name');
        $check_count = ColumnModel::where('name',trim($data['name']))->count();
        if($check_count){
            return Response::false(1116,'存在相同的栏目名称');
        }
        $insert = ColumnModel::create($data);

        return Response::success($insert);
    }

    public function updateColumn(Request $request)
    {
        $id = $request->get('id',0);
        if(!$id){
            return Response::error(1116,'缺少 Column ID');
        }
        $update = [];
        if($request->get('name')){
            $update['name'] = $request->get('name');
        }
        $check_count = ColumnModel::where('name',trim($update['name']))->where('id','<>',$id)->count();
        if($check_count){
            return Response::error(1116,'存在相同的栏目名称');
        }

        if($request->get('key')){
            $update['key'] = $request->get('key');
        }

        if($request->get('sort')){
            $update['sort'] = $request->get('sort');
        }

        if($request->get('is_show')){
            $update['is_show'] = $request->get('is_show');
        }
        $update_res = ColumnModel::where('id',$id)->update($update);
        if(!$update_res){
            return Response::error(1117,'更新失败');
        }
        return Response::success($update_res);

    }

    public function deleteColumn(Request $request){

        $id = $request->get('id',0);
        if(!$id){
            return Response::error(1118,'缺少 Column ID');
        }
        $res = ColumnModel::where('id',$id)->delete();
        if(!$res){
            return Response::error(1119,'删除失败');
        }
        return Response::success($res);
    }

    public function getColumn(Request $request)
    {
        $id = $request->get('id',0);
        if($id){
            $column_info = ColumnModel::find(intval($id))->toArray();
            return Response::success($column_info);
        }

        $column_list =ColumnModel::where('id','>',0)->orderBy('updated_at','desc')->get()->toArray();
        return Response::success($column_list);
    }

}