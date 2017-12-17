<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Models\Backend\RoleAuth;
use App\Http\Models\Backend\Roles;
use App\Http\Models\Backend\UserRole;
use App\Http\Models\Backend\Users;
use App\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth as OAuth;
use Illuminate\Http\Request;
class Admin extends Controller
{
    protected $request;

    use AdminTrait;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {

        $fill_able = [
            'name' => 'required|max:10|min:2',
            'password' => 'required|max:12|min:6',
        ];

        $message = [
            'name.required' => 'User_Name Required',
            'password.required' => 'Password Required'
        ];

        $remember = $this->request->has('remember') ? intval($this->request->has('remember')) : 0;
        $validator = Validator::make($this->request->all(), $fill_able, $message);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $data = $this->request->all();
        if (!Users::where('name', $data['name'])->count()) {
            return Response::error(200, 'Locked OR Must Reset');
        }
        $login = OAuth::attempt(['name' => trim($data['name']), 'password' => $data['password']], $remember);

        if (!$login) {
            return Response::error(1010, 'Login Failed,Please Try Again');
        }

        $user_id = auth()->user()->id;

        auth()->user()->update(['last_login_time' =>date('Y-m-d H:i:s',time())]);

        $nav = $this->initPrms($user_id);
        $user = Users::select('name', 'email', 'id', 'last_login_time')->find($user_id);
        $user['nav'] =array_values($nav['prms']);
        return Response::success($user);
    }

    /**
     * 初始化用户的权限节点数据
     * @param int $user_id
     * @return array|bool
     */
    protected function initPrms($user_id=0)
    {
        $role = auth()->user()->role->toArray();
        if(!$role){
            return false;
        }

        $role_ids = $this->arrayUniqueFilter(array_column($role, 'id'));
        if(!$role_ids){
            return false;
        }

        $auth_info = Roles::getPrms($role_ids)->get()->toArray();
        $auth_info = array_column($auth_info,null,'id');
        session(['prms_info' =>json_encode($auth_info)]);
        return ['role'=>$role , 'prms' =>$auth_info];
    }

    /**
     * 更新用户的角色信息
     * @return mixed
     */
    public function updateRole(){
        $user_id = $this->request->get('user_id',0);
        $role_ids = $this->request->get('role_id',[]);
        if(!$user_id){
           return  Response::error(403,'没有用户信息');
        }
        if(!$role_ids){
            return  Response::error(403,'没有角色信息');
        }

        Users::find($user_id)->role()->detach();
        $res = Users::find($user_id)->role()->attach($role_ids);
        if(!is_null($res)){
            return Response::error('2201','添加角色失败');
        }
        return Response::success('添加成功');
    }

    /**
     * 锁定用户信息
     * @return mixed
     */
    public function lockUser()
    {
        $user_id = $this->request->get('user_id',0);
        $locked = $this->request->get('is_lock',1);
        if(!in_array($locked,[0,1])){
            return Response::error('2301','锁定状态不合法');
        }
        if(!$user_id){
            return Response::error('2303','未知用户');
        }

        $res = User::find($user_id)->update(['locked'=>intval($locked)]);
        if(!$res){
            return Response::error('2302','修改锁定状态失败');
        }
        return Response::success('修改锁定状态成功');
    }

}