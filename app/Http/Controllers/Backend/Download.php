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

    public function edit(Request $request)
    {
        $down_id = $request->get('id',0);
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        if($request->method() == 'GET'){
            if(!$down_id){
                $download =[];
            }else{
                $download = DownloadModel::find($down_id)->toArray();
            }

            return view('admin.download.edit-download',['download'=>$download])
                ->with(['prms' => $prms, 'roles_info' => $role]);
        }

        $insert_data = [
            'type'=>$request->get('type'),
            'table_name'=>$request->get('table_name'),
            'jpg_url'=>$request->get('jpg_url'),
            'pdf_url'=>$request->get('pdf_url'),
        ];

        if(!$down_id){
            $download = DownloadModel::create($insert_data);
        }else{
            $insert_data = array_filter($insert_data);
            $download = DownloadModel::where('id',$down_id)->update($insert_data);
        }
        return view('admin.download.edit-download',['download'=>$download])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function delete(Request $request)
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $down_id = $request->get('id');

        $download = DownloadModel::find($down_id)->toArray();
        DownloadModel::where('id',$down_id)->delete();
        $down_list = DownloadModel::where('type',$download['type'])->get()->toArray();
        return view('admin.download.index-download',['download_list'=>$down_list])->with(['prms' => $prms, 'roles_info' => $role]);
    }
}