<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/20
 * Time: 23:34
 */
namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Request;
class MemberController extends \App\Http\Controllers\Controller{
    public function __construct()
    {
    }
    public function user(Request $request){

        $user_id = $request->get('user_id',0);
        if($user_id){
            $user = User::find($user_id)->toArray();
        }else{
            $page = $request->get('page',1);
            $page_num = $request->get('page_num',20);
            $offset = ($page - 1) * $page_num;
            $user_db = User::where('id','>',0);
            if($status =$request->get('status')){
                $user_db = $user_db->where('status',$status);
            }
            if($source   =$request->get('source')){
                $user_db = $user_db->where('source',$source);
            }

            if($name   =$request->get('name')){
                $user_db = $user_db->where('name','like',$name."%");
            }

            $user_db = $user_db->skip($offset)->take($page_num);
            $user = $user_db->get()->toArray();
        }

        return response()->success($user);
    }
}