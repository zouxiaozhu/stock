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
use Illuminate\Support\Facades\Request;

class Comment extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function audit_ace()
    {
        $column = $this->request->get('column_id');
        $article_id = $this->request->get('article_id');

    }

    public function audit_comment()
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
        $ace_db = $ace_db->paginate(5);

        return view('admin.ace.index-ace', ['ace_list' => $ace_db])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }


}

