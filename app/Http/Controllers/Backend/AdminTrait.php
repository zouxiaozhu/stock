<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/17
 * Time: 16:50
 */
namespace App\Http\Controllers\Backend;
use App\Http\Models\Backend\Roles;

trait AdminTrait{

    public function arrayUniqueFilter($array = []){
        if(!is_array($array)){
            return false;
        }
        if(!$array){
            return [];
        }

        $array = array_filter(array_unique($array));
        return $array;
    }

    public function check_login()
    {

        if(!(session()->get('user_info'))){
         return false;
        }


    }

    public function get_role_list()
    {
        return Roles::where('id','>',1)->orderBy('id','ASC')->get()->toArray();
    }
}