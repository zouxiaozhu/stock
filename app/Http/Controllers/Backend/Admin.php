<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\UserModel\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
class Admin extends Controller{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function login(){
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
        if (!User::where('name', $data['name'])->count()) {
            return Response::error(200,'Locked OR Must Reset');
        }
        $login = OAuth::attempt(['name' => trim($data['name']), 'password' => $data['password']],$remember);
        if(!$login){
            return Response::error(1010,'Login Failed,Please Try Again');
        }

        $user_id = auth()->user()->id;
        auth()->user()->update(['last_login_time'=>time()]);
        $this->initPrms($user_id);
        return $user = User::select('name','email','id','last_login_time')->find($user_id);
    }

    public function initPrms($id)
    {
        $role = auth()->user()->role->toArray();
        $prms = $this->arrayFilter(array_column($role,'prms'));
        $role_ids = $this->arrayFilter(array_column($role,'id'));
        $prms_info = array_column(Roles::getPrms($role_ids)->get()->toArray(),'prm');
        session(['prms_info'=>$this->arrayFilter($prms_info)]);
    }



}