<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 0:57
 */
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\AceModel;
use App\Http\Models\Backend\AnalyModel;
use App\Http\Models\Backend\EventModel;
use App\Http\Models\Backend\NewsModel;
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


        $all_column = [
             ''=>'----请选择----',
             "EveryDayAnalysis"=>"每日分析", // analy
             "FinancialLog"=>"财经日志", // event
             "Announcement"=>"公告",  // news
             "News"=>"财经新闻",  // news
             "WhoIsGSDetail"=>" 谁是高手详情", //ace
             "NewsDetail"=>" 新闻详情", //news
      ];

        $column_info['column'] = isset($column_info['column'])  ?  $column_info['column']  : "";

        $post_infos = $this->get_posts($column_info['column']) ? : [];
        return view('admin.column.add-column',
            ['column_info'=>$column_info, 'all_column'=>$all_column
             ,'post_infos'=>$post_infos
            ])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }
//case 0:
//$detail = AceModel::find($post_id)->toArray();
//break;
//case 1:
//$detail = EventModel::find($post_id)->toArray();
//break;
//case 2:
//$detail = NewsModel::find($post_id)->toArray();
//break;
//case 3:
//$detail = EconModel::find($post_id)->toArray();
//break;
    //帖子类型 0-ace 1-event 财经日志 2 news_财经新闻财经公告 3经济数据 econ
    public function updateColumn(Request $request)
    {
        $column_id = $request->get('column_id',0);
        $name = $request->get('name');
        $is_show = $request->get('is_show',0);
        $key = $request->get('key','');
        $sort = $request->get('sort',1);
        $column = $request->get('column', '');
        $time = Carbon::now()->timestamp;
        $content_id = $request->get('content', 0);
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();

            $upload_image_name = $time . mt_rand(0, 10000) . '.' . $ext;
            $res = $file->move(env('FILE_STORAGE_PATH', ''), $upload_image_name);
            $data['storage_path'] = env('FILE_STORAGE_PATH', '') . '/' . $upload_image_name;
            $pic_url = (env('APP_URL')) . substr($data['storage_path'], 1);
        }

        $pic_url = isset($pic_url)?$pic_url :'';
        $url = $request->get('url','');

        $insert_data = $update_data = [
            'name'=>$name,'is_show'=>$is_show,'key'=>$key,'url_link'=>$url, 'column'=>$column,
            'content_id'=>$content_id
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

    public function post_infos(Request $request)
    {
        $column = $request->get('column');

        $post_infos = $this->get_posts($column);
        echo json_encode($post_infos);
        die;

    }


    public function get_posts( $column = '')
    {
        if(!$column ) return [];
        $column_info['column'] = $column;
        switch ($column_info['column']){
            case "EveryDayAnalysis":
//              $post_infos = AnalyModel::where('id','>','0')->where('lang', 1)->orderBy('id','desc')->take(20)->skip(0)->select('id','title as content')->get()->toArray();
                $post_infos = [
                    ['id'=>1, 'content'=>'倫敦黃金'],
                    ['id'=>2, 'content'=>'倫敦白銀'],
                    ['id'=>3, 'content'=>'歐元'],
                    ['id'=>4, 'content'=>'日元'],
                    ['id'=>5, 'content'=>'英鎊'],
                    ['id'=>6, 'content'=>'瑞郎'],
                    ['id'=>7, 'content'=>'澳元'],
                    ['id'=>8, 'content'=>'紐元'],
                    ['id'=>9, 'content'=>'加元'],
                    ['id'=>10, 'content'=>'港股分析'],
                    ['id'=>11, 'content'=>'昨日市場總結'],
                    ['id'=>12, 'content'=>'市場焦距']
                ];
            break;

            case "FinancialLog":
//              $post_infos = EventModel::where('event_id','>','0')->orderBy('event_id','desc')->take(20)->skip(0)->select('event_id as id','title as content')->get()->toArray();
              $post_infos = [
                    ['id'=>1, 'content'=>'以公布'],
                    ['id'=>0, 'content'=>'未公布']
                ];
                break;
            case "Announcement":
                $post_infos = [];
                break;
            case "News":
                $post_infos = [];
                break;
            case "NewsDetail":
                $post_infos = NewsModel::where('news_id','>','0')->where('type', 1)->orderBy('news_id','desc')->take(20)->skip(0)->select('news_id as id','title as content')->get()->toArray();
                break;
            case "WhoIsGSDetail":
                $post_infos = AceModel::where('id','>','0')->orderBy('id','desc')->take(20)->skip(0)->select('id','comment as content')->get()->toArray();
                break;
            default:
                $post_infos = [];
        }
        if($column_info['column'] == 'News' )
//        if($column_info['column'] == 'EveryDayAnalysis' || $column_info['column'] == 'News' )
        {
            foreach ($post_infos as  $k => $info){
                if($content = unserialize($info['content'])){
                    if(is_array($content)) {
                        $content = $content[0];
                    }

                }
                    $post_infos[$k]['content'] = ($content) ?
                        : '每日分析'.$info['id'] ;

            }


        }

            return $post_infos;
    }
}