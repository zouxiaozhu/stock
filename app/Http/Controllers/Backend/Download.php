<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/4
 * Time: 12:08
 */
namespace App\Http\Controllers\Backend;
use App\Http\Models\Backend\DownloadModel;
use Illuminate\Http\Request;

class Download extends \App\Http\Controllers\Controller{

    public function __construct()
    {


    }

    public function index(Request $request)
    {
        //下载类型:1=>英皇金业,2=>英皇证券,3=>英皇期货
        $type = $request->get('type',1);

        $down_list = DownloadModel::where('type',intval($type))->get()->toArray();
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        return view('admin.download.index-download',['download_list'=>$down_list])->with(['prms' => $prms, 'roles_info' => $role]);
    }
}