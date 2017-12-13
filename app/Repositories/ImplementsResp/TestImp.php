<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/13
 * Time: 22:11
 */
namespace App\Repositories\ImplementResp;
use App\Repositories\RepositoryInterfaces\TestInterface;
class TestImp implements TestInterface{

    public function demo($a, $b)
    {
        echo 'suceess';die;
    }

}