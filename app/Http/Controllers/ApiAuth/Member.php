<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 0:50
 */
namespace App\Http\Controllers\ApiAuth;
use \App\Http\Controllers\Controller;
use App\Http\Models\Backend\MembersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
class Member extends Controller{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_predis = new \Predis\Client([
            $config = array_merge(array(
                'host' => '127.0.0.1',
                'port' => 6379,
                'database' => 0
            ), [
                'host'=>env('REDIS_HOST'),
                'port'=>env('REDIS_PORT'),
                'database'=>env('REDIS_DATABASE',0)
            ])
        ]);

    }
    use ApiAuthTrait;
    protected $image_type = ['jpg', 'jpeg', 'png', 'bmp'];

    public function updateMember(Request $request)
    {   //上传原图
        $member = $this->decode_access_token($request->get('access_token'));

        if($request->get('name')){
            $update['name'] = $request->get('name');
        }
        if($request->get('email')){
            $update['email'] = $request->get('email');
        }
        if($request->get('phone')){
            $update['phone'] = $request->get('phone');
        }

        if ($request->hasFile('file')) {

            $time = Carbon::now()->timestamp;
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
//            if (!in_array(strtolower($ext), $this->image_type)) {
//                return $this->res_error('文件格式不正确', 1203);
//            }
            $upload_image_name = $time . mt_rand(0, 10000) .'.'. $ext;
            $res = $file->move(env('FILE_STORAGE_PATH',''), $upload_image_name);
            if (!$res) {
                return $this->res_error('上传文件失败',1204);
            }
            $data['storage_path'] = env('FILE_STORAGE_PATH','').'/'.$upload_image_name;
            $update['avatar'] = (env('APP_URL')).substr($data['storage_path'],1);
        }

        MembersModel::where('id',$member['id'])->update($update);

        $member_info = MembersModel::find($member['id'])->toArray();


        $redis_bool = $this->_predis->setex(
            $request->get('access_token'),
            env('REDIS_EXPIRE_TIME',3600),
            json_encode($member_info)
        );

        $member_info['phone'] = strval($member_info['phone']);
        $member_info['id'] = strval($member_info['id']);
        $this->res_true($member_info);
    }

    public function res_true($data = '')
    {
        echo json_encode(['error_code'=>'0','data'=>$data]);die;
    }

    public function res_error($msg='',$code=400,$status=false)
    {
        echo json_encode(['error_code'=>$code,
                          'status'=>$status,
                          'error_message'=>$msg,
        ]);die;
    }

}