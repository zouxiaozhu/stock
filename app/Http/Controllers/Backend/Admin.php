<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Roles;
use App\Http\Models\Backend\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        if($this->request->method() == 'GET'){


            if(session()->get('user_info')){
                return  Redirect::to('admin/home');
                die();
            }
            return view('admin.auth.login');
        }
//            if(session()->get('user_info')){
//                return redirect()->to('admin/home');die;
//            }

        $fill_able = [
            'name' => 'required|max:50|min:2',
            'password' => 'required|max:12|min:6',
        ];

        $message = [
            'name.required' => 'User_Name Required',
            'password.required' => 'Password Required'
        ];

        $remember = $this->request->has('remember') ? intval($this->request->has('remember')) : 0;
        $validator = Validator::make($this->request->all(), $fill_able, $message);

        if ($validator->fails()) {
            return Response::error(1015,$validator->errors()->first());
        }

        $data = $this->request->all();
        if (Users::where('name', trim($data['name']))->where('locked',1)->count()) {
            return Response::false(1011, '用户被禁用');
        }
        $login = OAuth::attempt(['name' => trim($data['name']), 'password' => $data['password']], $remember);

        if (!$login) {
            return Response::false(1012, '用户名或者密码错误请重试或者联系管理员');
        }

        $user_id = auth()->user()->id;

        auth()->user()->update(['last_login_time' =>date('Y-m-d H:i:s',time())]);
        session()->put('user_info', auth()->user()->select('id','name','avatar')->find($user_id)->toArray());

        $nav = $this->initPrms($user_id);
        $user = Users::select('name', 'email', 'id', 'last_login_time')->find($user_id);
        $user['nav'] = array_values($nav['prms']);
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
        session()->put('prms_info',json_encode($auth_info));
        session()->put('roles_info',json_encode($role));
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

    /**
     * 首页信息
     * @return mixed
     */
    public function home()
    {
        $user_id =auth()->user()->id;
        if(!$user_id){
            return Response::error('2303','未知用户');
        }
        $prms = json_decode(session()->get('prms_info'),true);
        $role = json_decode(session()->get('roles_info'),true);
        return  view('admin.auth.home')
                ->with(['prms'=>$prms,
                'roles_info'=>$role
                ]);
    }

    /**
     * 管理员退出
     * @return mixed
     */
    public function logout(){
        session()->flush();
        $user =auth()->user();
        if(!$user){
            return  Redirect::to('admin/login');
        }
        Auth::logout();

        if (Auth::check()) {
            return response()->error(1027, 'Logout Failed');
        }

        return  Redirect::to('admin/login');
    }



}