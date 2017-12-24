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
        $this->member_info = $member_info[0];
    }
    public function addComment(Request $request){
        $member_info =  $this->member_info;
        $member_id = $member_info['id'];

        $fill_able = [
            'ace_id' => 'required',
        ];

        $message = [
            'ace_id.required' => 'article Required',
        ];

        $validator = Validator::make($request->all(), $fill_able, $message);

        if ($validator->fails()) {
            return Response::false(1015,$validator->errors()->first());
        }
        /**
        $table->integer('ace_id')->comment('帖子id');
        $table->integer('ace_comment_fid')->comment('主回复')->default(0);
        $table->string('reply_member_id')->comment('父级评论回复的会员名称')->nullable();
        $table->integer('member_id')->comment('会员id')->default(0);
        $table->integer('like_num')->comment('点赞数')->default(0);
        $table->integer('dislike_num')->comment('反对数')->default(0);
        $table->enum('status',[0,1,2,3])->comment('0被删除 1正常 3 待审核 2已恢复')->nullable();
         */
        $is_audit = TerminalSettings::where('key','comment')->get()->toArray()[0]['value'];//1需要审核  0 不用审核
        switch ($is_audit){
            case 1:
                $status = 3;
                $msg = ',待审核';
                break;
            case 0:
                $status = 1;
                $msg = '';
                break;
        }



        $insert = [
            'ace_id' => intval($request->get('ace_id')),
            'ace_comment_fid'=>$request->get('ace_comment_fid',0),
            'reply_member_id'=>$request->get('reply_member_id',0),
            'member_id'=>$member_id,
            'status'=>$status
        ];
        CommentModel::insert($insert);
        return Response::success('评论成功'.$msg);
    }
}