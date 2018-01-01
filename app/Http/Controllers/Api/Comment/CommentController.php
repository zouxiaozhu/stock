<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24
 * Time: 15:58
 */
namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\ApiAuth\ApiAuthTrait;
use App\Http\Controllers\Controller;
use App\Http\Models\Api\CommentModel;
use App\Http\Models\Backend\AceModel;
use App\Http\Models\Backend\ColumnModel;
use App\Http\Models\Backend\TerminalSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller{
    use ApiAuthTrait;
    protected $access_token;
    protected $member_info;
    public function __construct(Request $request)
    {
        $this->access_token = trim($request->get('access_token'));
        if(!$member_info = $this->decode_access_token($this->access_token)){
            return response()->false(1111,'token不合法 或者 失效');
        }
        $this->member_info = $member_info;
    }

    public function addComment(Request $request){
        $member_info =  $this->member_info;
        $member_id = $member_info['member_id'];

        $fill_able = [
            'ace_id' => 'required',
            'content'=>'required'
        ];

        $message = [
            'ace_id.required' => 'article Required',
        ];

        $validator = Validator::make($request->all(), $fill_able, $message);

        if ($validator->fails()) {
            return Response::false(1015,$validator->errors()->first());
        }

        $is_audit = TerminalSettings::where('key','comment')->get()->toArray()[0]['value'];//1需要审核  0 不用审核
        switch ($is_audit){
            case 1:
                $status = 3;
                $msg = '成功,待审核';
                break;
            case 0:
                $status = 1;
                $msg = '成功';
                break;
        }

        $insert = [
            'ace_id' => intval($request->get('ace_id')),
            'ace_comment_fid'=>$request->get('ace_comment_fid',0),
            'reply_member_id'=>$request->get('reply_member_id',0),
            'reply_member_name'=>$request->get('reply_member_name',''),
            'member_id'=>$member_id?:0,
            'status'=>intval($status),
            'content'=>trim($request->get('content'))
        ];
        $ret = CommentModel::insert($insert);
        $auction = $request->get('reply_member_id',0) ? '回复':'评论';

        if(!$ret){
            $msg = '失败';
            return Response::false($auction.$msg);
        }

        return Response::success($auction.$msg);
    }


    /**
     * 获取帖子下面的评论
     * @param Request $request
     * @return mixed
     */
    public function getComment(Request $request)
    {
        $ace_id = $request->get('ace_id');
        if(!$ace_id){
            return Response::false('没有ace_id');
        }

        $page = $request->get('page');
        $page_size = $request->get('page_size',10);
        $offset = (max($page,1)-1) *max($page_size,0);
        $comment_f = CommentModel::where('ace_id',intval($ace_id))
            ->where('ace_comment_fid',0)
            ->where('status',1)
            ->take($page_size)
            ->skip($offset)
            ->get()->toArray();
        if(!$comment_f){
            return response()->success([]);
        }
        $fids = array_column($comment_f,'id');

        $comment_c = CommentModel::where('ace_id',intval($ace_id))
            ->whereIn('ace_comment_fid',$fids)
            ->where('status',1)
            ->get()->toArray();

        $c_com = [];
        foreach ($comment_c as $com){
            $c_com[$com['ace_comment_fid']][]= $com;
        }

        $new_list = [];
        foreach ($comment_f as $f_com){
            $new_list[$f_com['id']]['comment'] = $f_com;
            $new_list[$f_com['id']]['comment']['child_comment'] = $c_com[$f_com['id']]?:[];
        }

        return response()->success(array_values($new_list));

    }
}