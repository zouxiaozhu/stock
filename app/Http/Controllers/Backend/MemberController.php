<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/20
 * Time: 23:34
 */
namespace App\Http\Controllers\Backend;

use App\Http\Models\Backend\MembersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MemberController extends \App\Http\Controllers\Controller{
    public function __construct()
    {
    }
    public function member(Request $request){

            $prms = json_decode(session()->get('prms_info'), true);
            $role = json_decode(session()->get('roles_info'), true);
            $page = max(1,$request->get('page')) ;
            $page_num = $request->get('page_num',20);
            $offset = ($page - 1) * $page_num;
            $user_db = MembersModel::where('id','>',0);

            if($request->has('status') && in_array($request->get('status'),[0,1])){
                $user_db = $user_db->where('status',$request->get('status'));
            }
            if($source =$request->get('source')){
                if(strtolower($source) == 'facebook'){
                    $source = 2;
                }
                if(strtolower($source) == '微信' or strtolower($source) == 'wechat'){
                    $source = 1;
                }
                $user_db = $user_db->where('source',$source);
            }

            if($name =$request->get('name')){
                $user_db = $user_db->where('name','like',$name."%");
            }

        $member_list = $user_db->paginate(5);
//             $member_list= $user_db->get()->toArray();

//            $user_db = $user_db->skip($offset)->take($page_num);
//            $user = $user_db->get()->toArray();
        return view('admin.member.index-member', ['member_list' => $member_list])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }


    public function delMember(Request $request)
    {
        $memeber_id = $request->get('member_id', 0);
        if($memeber_id){
            MembersModel::find(intval($memeber_id))->delete();
        }

        return Redirect::to('admin/index-member');
    }
}