<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/7
 * Time: 18:40
 */

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\TerminalSettings;
use App\Http\Requests\Request;


class Setting extends Controller{
    public function _construct()
    {

    }

    public function index()
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);

        $setting = TerminalSettings::get()->toArray();
        return view('admin/setting/index-setting',['settings'=>$setting])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $id = $request->get('id',0);
        $value = $request->get('value',0);
        $ret = TerminalSettings::where('id',$id)->update(['value'=>$value]);
        if($ret){
            return $this->res_true('更新成功');
        }

        return $this->res_error('更新失败');
    }

    public function delete(\Illuminate\Http\Request $request)
    {
        $id = $request->get('setting_id',0);
        TerminalSettings::where('id',$id)->delete();
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);

        $setting = TerminalSettings::get()->toArray();
        return view('admin/setting/index-setting',['settings'=>$setting])
            ->with(['prms' => $prms, 'roles_info' => $role]);
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