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
        $member_info= $this->decode_access_token($this->access_token);

        if(!$member_info){
          echo json_encode(['error_code'=>4004,'data'=>'登录过期，重新登录']);die;
        }

        $this->member_info = $member_info;
    }

    public function addComment(Request $request){
        $member_info =  $this->member_info;
        $member_id = $member_info['id'];

        $fill_able = [
            'type'=>'required',
            'post_id' => 'required',
            'content'=>'required'
        ];

        $message = [
            'post_id.required' => '必须评论有效帖子',
            'type.required' => '类型必须传',
            'content.required'=>'内容不能为空 '
        ];

        $validator = Validator::make($request->all(), $fill_able, $message);

        if ($validator->fails()) {
            return $this->res_error($validator->errors()->first());
        }

        $is_audit = TerminalSettings::where('key','comment')->get()->toArray()[0]['value'];//1需要审核  0 不用审核
        switch ($is_audit){
            case 1:
                $status = 2;
                $msg = '成功,待审核';
                break;
            case 0:
                $status = 1;
                $msg = '成功';
                break;
        }

        $insert = [
            'post_id' => intval($request->get('post_id')),
            'post_comment_fid'=>$request->get('post_comment_fid',0),
            'reply_member_id'=>$request->get('reply_member_id',0),
            'reply_member_name'=>$request->get('reply_member_name',''),
            'member_id'=>$member_id?:0,
            'status'=>intval($status),
            'content'=>trim($request->get('content')),
            'type'=>$request->get('type',0)
        ];
        $ret = CommentModel::insert($insert);
        $auction = $request->get('reply_member_id',0) ? '回复':'评论';

        if(!$ret){
            $msg = '失败';
            return $this->res_error($auction.$msg);
        }

        return $this->res_true($auction.$msg);
    }

    //帖子类型 0-ace 1-event 财经日志 2 news_财经新闻财经公告 3经济数据 econ
    /**
     * 获取帖子下面的评论
     * @param Request $request
     * @return mixed
     */
    public function getComment(Request $request)
    {
        $post_id = $request->get('post_id');
        $type = $request->get('type',0);
        if(!in_array($type,[0,1,2,3])){
            return $this->res_error('帖子类型不合法');
        }
        if(!$post_id){
            return $this->res_error('没有帖子信息');
        }

        $page = $request->get('page');
        $page_size = $request->get('page_size',10);
        $offset = (max($page,1)-1) * max($page_size,0);
        $comment_f = CommentModel::where('post_id',intval($post_id))
            ->where('post_comment_fid',0)
            ->where('status',1)
            ->where('type',$type)
            ->take($page_size)
            ->skip($offset)
            ->get()->toArray();

        if(!$comment_f){
            return $this->res_true([]);
        }
        $fids = array_column($comment_f,'id');

        $comment_c = CommentModel::where('post_id',intval($post_id))
            ->whereIn('post_comment_fid',$fids)
            ->where('status',1)
            ->get()->toArray();

        $c_com = [];
        foreach ($comment_c as $com){
            $c_com[$com['post_comment_fid']][]= $com;
        }

        $new_list = [];
        foreach ($comment_f as $f_com){
            $new_list[$f_com['id']]['comment'] = $f_com;
            $new_list[$f_com['id']]['comment']['child_comment'] = isset($c_com[$f_com['id']]) ? $c_com[$f_com['id']]:[];
        }

        return response()->success(array_values($new_list));

    }

    /**
     * 获取自己的评论信息
     * @param Request $request
     */
    public function getMyComment(Request $request)
    {
        $member_info = $this->member_info;
        $member_id = $member_info['id'];
//        var_export($member_id);die;
        $page = $request->get('page')?:1;
        $page_size = $request->get('page_size')?:10;
        $offset = ($page - 1 ) * $page_size;
        $status = $request->has('status') ? explode(',',$request->get('status')) : [1,2,3];
        $comment = CommentModel::where('member_id',$member_id)
                    ->whereIn('status',$status)
                    ->where('type',0)
                    ->skip($offset)
                    ->take($page_size)
                    ->orderBy('created_at','desc')
                    ->get()
                    ->toArray();
        $new_comment = [];

        foreach ($comment as $com){

            if($com['post_comment_fid']){
                // 查找上级回复
                $new_comment['comment'][$com['id']]= $com;
                $new_comment['comment'][$com['id']]['father']=AceModel::find($com['post_comment_fid']) ? AceModel::find($com['post_comment_fid'])->toArray() : [] ;
            }else{
                // 查找上级回复 如果没有找到帖子
                $new_comment['comment'][$com['id']]= $com;
                $new_comment['comment'][$com['id']]['father']=AceModel::find($com['post_id'])? AceModel::find($com['post_id'])->toArray() :[];
            }
        }
        $new_comment['comment'] = array_values($new_comment['comment']);

        return response()->success($new_comment ?:[]);
    }


    public function getPost(Request $request){

        $page = $request->get('page')?:1;
        $page_size = $request->get('page_size')?:10;
        $offset = ($page - 1 ) * $page_size;
        $member_info = $this->member_info;
        $member_id = $member_info['id'];
        $my_post = AceModel::where('create_user_id',$member_id)
            ->skip($offset)
            ->take($page_size)
            ->orderBy('create_time','desc')
            ->get()
            ->toArray();
        $this->res_true($my_post);
    }

    public function res_true($data = '')
    {
        echo json_encode(['error_code'=>0,'data'=>$data]);die;
    }

    public function res_error($msg='',$code=400,$status=false)
    {
        echo json_encode(['error_code'=>$code,
                          'status'=>$status,
                          'error_message'=>$msg,
        ]);die;
    }
}