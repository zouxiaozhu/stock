<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/19
 * Time: 23:23
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Roles;
use App\Http\Models\Backend\Users;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
{
    use AdminTrait;
    public function __construct()
    {
        $bool = $this->check_login();
//        if(!$bool){
//            return redirect()->action('Backend\Admin@login');die;
//        }

    }

    public function user()
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $user = User::where('id', '>', '1')->orderBy('updated_at', 'desc')->get()->toArray();
//var_export(session('prms_info'));die;
        return view('admin.user.index-user', ['user_list' => $user])
            ->with(['prms' => $prms, 'roles_info' => $role]);
    }

    public function addUser(Request $request)
    {
        $role_list = $this->get_role_list();
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $user_id = $request->get('user_id', 0);
        if (!$user_id) {
            $user_info = [];
        } else {
            $user_info = Users::with('role')->find($user_id)->toArray();
        }
        return view('admin.user.add-user',['user_info'=>$user_info,'role_list'=>$role_list])->with(['prms' => $prms, 'roles_info' => $role]);

    }

    public function updateUser(Request $request)
    {
        $user_id = $request->get('user_id');
        $name = $request->get('name');
        $locked = $request->get('locked');
        $password = ($request->get('password'));
        $role = $request->get('role') ? :[];
        $email = $request->get('email','');
        $phone = $request->get('phone',0);
        if($user_id){

            $update_data = [
                'name'=>$name,'locked'=>$locked,'phone'=>$phone
            ];
            if(Hash::needsRehash($password)){
                $update_data['password'] = Hash::make($password);
            }

            if($email){
                $update_data['email'] = $email;
            }
            Users::where('id',$user_id)->update($update_data);
        }else{
            $insert_data = [
                'name'=>$name,'locked'=>$locked,'password'=>Hash::make($password),'email'=>$email,'phone'=>$phone,'create_user_id'=>auth()->user()->id
            ];

            $user = Users::create($insert_data);
            $user_id = $user->id;
        }

        Users::findOrFail($user_id)->role()->detach();

        $ret = Users::findOrFail($user_id)->role()->attach($role);
//        $prms = json_decode(session()->get('prms_info'), true);
//        $role = json_decode(session()->get('roles_info'), true);
        return  Redirect::to('admin/index-user');
    }


    public function delUser(Request $request)
    {
        $user_id = $request->get('user_id',0);

        if(!$user_id)return  Redirect::to('admin/index-user');
        Users::where('id',$user_id)->delete();
        return  Redirect::to('admin/index-user');

    }
}