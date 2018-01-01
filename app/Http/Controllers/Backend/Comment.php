<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 0:58
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Models\Api\CommentModel;
use App\Http\Models\Backend\AceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class Comment extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function auditAce()
    {
        $ace_id = $this->request->get('ace_id');
        $status = $this->request->get('status');
        AceModel::where('id',$ace_id)->update(['rule_result'=>$status]);
        return Response::success(2000,'操作成功');
    }

    public function auditComment()
    {

        $comment_id = $this->request->get('comment_id');
        $status = $this->request->get('status'); // 0 被删除 1正常 2 已恢复  3 待审核
        CommentModel::where('id',$comment_id)->update(['status'=>$status]);
        return view();
    }

    /**
     * 帖子列表
     */
    public function ace()
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $ace_db = AceModel::where('id', '>', '0');
        $ace_db = $ace_db->paginate(20);

        return view('admin.ace.index-ace', ['ace_list' => $ace_db])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function detailAce(\Illuminate\Http\Request $request)
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $ace_id = $request->get('id',0);
        $detail = AceModel::find($ace_id)->toArray();
        $comment_father_list = CommentModel::where('ace_id',$ace_id)->where('ace_comment_fid',0)->get()->toArray();
        $father_ids = array_column($comment_father_list,'id');
        $comment_child_list = CommentModel::where('ace_id',$ace_id)->whereIn('ace_comment_fid',$father_ids)->where('ace_comment_fid','>',0)->orderBy('updated_at','desc')->get()->toArray();

        $new_child_list = [];
        foreach ($comment_child_list as $child){
            $new_child_list[$child['ace_comment_fid']][] = $child;
        }

        $comment_page = CommentModel::where('ace_id',$ace_id)->where('ace_comment_fid',0)->paginate(20);

        return view('admin.ace.edit-ace', [
            'ace_detail' => $detail,
            'comment_page'=>$comment_page,
            'new_child_list'=>$new_child_list
        ])->with(['prms' => $prms, 'roles_info' => $role]);
        
    }



}

