<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 0:50
 */
namespace App\Http\Controllers\ApiAuth;
use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Member extends Controller{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}