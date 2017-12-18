<?php
/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/6/13
 * Time: 上午9:42
 */
namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\MediaManage;
use App\Models\WaterSetting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
define('IMAGE',1);
define('AUDIO',2);
define('VIDEO',3);
define('FILE',4);

class ImagesController extends Controller
{
    // $table->enum('type',[1,2,3,4])->comment('图片 音频 视频 文件');
    protected $image_type = ['jpg', 'jpeg', 'png', 'bmp'];

    public function image(Request $request,$module='/module')
    {   //上传原图

        if (!$request->hasFile('file')) {
            return response()->error(1202, 'REQUIRED FILE');
        }
        $MOUDLE = $request->get('module') ?: $module;
        $time = Carbon::now()->timestamp;
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if (!in_array(strtolower($ext), $this->image_type)) {
            return response()->error(1203, 'IMAGE TYPE INVALID');
        }
        $upload_image_name = $time . mt_rand(0, 10000) . $file->getClientOriginalName();
        $upload_image_path = env('FILE_STORAGE_PATH') . $MOUDLE . '/' . $upload_image_name;
        $res = $file->move(env('FILE_STORAGE_PATH') . $MOUDLE, $upload_image_name);

        if (!$res) {
            return response()->error(1204, 'UPLOAD IMAGE FAILED');
        }
        $data['type'] = IMAGE;
        $data['storage_path'] = $upload_image_path;
        $row = MediaManage::create($data);

        if(!$row){
            return response()->error(1204, 'UPLOAD IMAGE FAILED');
        }
        return response()->success(['path' => $upload_image_path]);
    }

    public function addWater($image_path)
    {
        $water = WaterSetting::where('is_use', 1)->first();;
        $water->opacity = $water->opacity ? $water->opacity : 70;
        $water_dir = env('WATER_PATH') . '/Water' . $water->id;
        if (!is_dir($water_dir)) {
            mkdir($water_dir, 0777);
        }
        $water_image_path = $water_dir . '/' . Carbon::now()->timestamp . mt_rand(0, 100) . '.jpg';
        $img = Image::make($image_path)->insert(Image::make($water->water_path)->resize($water->width, $water->height)->opacity($water->opacity), 'bottom-right', $water->bottom_left, $water->bottom_top)->resize(500, 500)->save($water_image_path);
        return $water_image_path;
    }





    public function uploadWaterPic(Request $request)
    {
        return $this->image($request,'waterspic');
    }

    public function manageWaterPic()

    {

    }


}

