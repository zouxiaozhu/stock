<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Auths;
use App\Http\Models\Backend\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller{
    public function __construct()
    {


    }


    public function role()
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $role_list = Roles::where('id', '>', '1')->
            orderBy('updated_at', 'asc')
            ->get()->toArray();
        return view('admin.role.index-role', ['role_list' => $role_list])
            ->with(['prms' => $prms, 'roles_info' => $role]);

    }


    public function addRole(Request $request)
    {
        $prms = json_decode(session()->get('prms_info'), true);
        $role = json_decode(session()->get('roles_info'), true);
        $role_id = $request->get('role_id', 0);
        if (!$role_id) {
            $role_info = [];
        } else {
            $role_info = Roles::with('auth')->find($role_id)->toArray();
        }
         $auth_list = Auths::get()->toArray();
         return view('admin.role.add-role',['role_info'=>$role_info])->with(['prms' => $prms, 'roles_info' => $role,'auth_list'=>$auth_list]);

    }

    public function updateRole(Request $request){
        $role_id = $request->get('role_id',0);
        $name = $request->get('name');
        $auth_id = $request->get('auth',[]);
        $description = $request->get('description','');

        if($role_id){
            $update_data = [
                'name'=>$name,'description'=>$description
            ];
            Roles::where('id',$role_id)->update($update_data);
        }else{
            $insert_data = [
                'name'=>$name,'description'=>$description
            ];

           $role = Roles::create($insert_data);
           $role_id = $role->id;
        }
        Roles::find($role_id)->auth()->detach();
        Roles::find($role_id)->auth()->attach($auth_id);
        return  Redirect::to('admin/index-role');

    }
    public function delRole(Request $request){

        $role_id = $request->get('role_id',0);
        Roles::find($role_id)->user()->detach();
        Roles::find($role_id)->auth()->detach();
        Roles::where('id',$role_id)->delete();
        return  Redirect::to('admin/index-role');
    }
}