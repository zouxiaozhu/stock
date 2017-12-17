<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/17
 * Time: 16:50
 */
namespace App\Http\Controllers\Backend;
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
}