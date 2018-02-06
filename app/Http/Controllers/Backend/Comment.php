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
use App\Http\Models\Backend\AnalogModel;
use App\Http\Models\Backend\FileModel;
use App\Http\Models\Backend\RegisterModel;
use Illuminate\Http\Request;
use App\Http\Models\Backend\EventModel;
use App\Http\Models\Backend\EconModel;
use App\Http\Models\Backend\NewsModel;
class Comment extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function auditAce()
    {
        $post_id = $this->request->get('ace_id');
        $status = $this->request->get('status');

        //帖子类型 0-ace 1-event 财经日志 2 news_财经新闻财经公告 3经济数据 econ
        AceModel::where('id',$post_id)->update(['rule_result'=>$status]);
        return $this->res_true(2000,'操作成功');
    }

    public function auditComment()
    {
        $comment_id = $this->request->get('com_id');
        $status = $this->request->get('status'); //
        // $msg = [0 被删除 1正常 2 已恢复  3 待审核]
        CommentModel::where('id',$comment_id)->update(['status'=>$status]);
        if($status == 0 ){
            $msg = '删除';
        }elseif($status == 1){
            $msg = '审核';
        }elseif($status==2){
            $msg = '修改';
        }
        $this->res_true($msg.'成功');
    }

    /**
     * 帖子列表
     */
    public function post()
    {
        //帖子类型 0-ace 1-event 财经日志 2 news_财经新闻财经公告 3经济数据 econ
        $type = $this->request->get('type',0);

        switch ($type){
            case  0 :
                $post_list = AceModel::where('id','>',0)
                    ->orderBy('create_time','DESC')->paginate(20);
                break;
            case 1 :
                $post_list = EventModel::where('event_id','>',0)
                    ->orderBy('create_time','DESC')->paginate(20);
                break;
            case 2:
                $post_list = NewsModel::where('news_id','>',0)
                    ->orderBy('create_time','DESC')->paginate(20);
                break;
            case 3:
                $post_list = EconModel::where('id','>',0)
                    ->orderBy('create_time','DESC')->paginate(20);
                break;
        }
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);

        return view('admin.ace.index-ace', ['post_list' => $post_list,'type'=>$type?:0])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function detailPost(\Illuminate\Http\Request $request)
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $post_id = $request->get('id',0);
        $type = $request->get('type',0);
        switch ($type){
            case 0:
                $detail = AceModel::find($post_id)->toArray();
                break;
            case 1:
                $detail = EventModel::find($post_id)->toArray();
                break;
            case 2:
                $detail = NewsModel::find($post_id)->toArray();
                break;
            case 3:
                $detail = EconModel::find($post_id)->toArray();
                break;
            //帖子类型 0-ace 1-event 财经日志 2 news_财经新闻财经公告 3经济数据 econ
        }

        $comment_father_list = CommentModel::where('post_id',$post_id)->where('post_comment_fid',0)->get()->toArray();
        $father_ids = array_column($comment_father_list,'id');

        $comment_child_list = CommentModel::where('post_id',$post_id)->whereIn('post_comment_fid',$father_ids)->where('post_comment_fid','>',0)->orderBy('updated_at','desc')->get()->toArray();

        $new_child_list = [];
        foreach ($comment_child_list as $child){
            $new_child_list[$child['post_comment_fid']][] = $child;
        }

        $comment_page = CommentModel::where('post_id',$post_id)->where('post_comment_fid',0)->paginate(20);

        return view('admin.ace.edit-ace', [
            'detail' => $detail,
            'comment_page'=>$comment_page,
            'new_child_list'=>$new_child_list,
            'type'=>$type
        ])->with(['prms' => $prms, 'roles_info' => $role]);
        
    }

    public function editComment()
    {
        return view('errors.503',['msg'=>'暂无开放']);
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

    public function register(Request $request)
    {
        $register_db = RegisterModel::where('id','>',0);
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);

        $page = max(1,$request->get('page')) ;
        $register_list = $register_db->paginate(15);


        return view('admin.register.index-register', ['register_list' => $register_list])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function editRegister(){
        return view('errors.503',['msg'=>'暂未开放']);
    }


    public function file(Request $request)
    {
        $file_db = FileModel::where('id','>',0);
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);

        $page = max(1,$request->get('page')) ;
        $file_list = $file_db->paginate(15);


        return view('admin.file.index-file', ['file_list' => $file_list])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }


    public function analog(Request $request)
    {
        $analog_db = AnalogModel::where('id','>',0);
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);


        $analog_list = $analog_db->paginate(15);


        return view('admin.analog.index-analog', ['analog_list' => $analog_list])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }
}

