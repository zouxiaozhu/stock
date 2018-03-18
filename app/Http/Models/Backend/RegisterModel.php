<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/5
 * Time: 22:32
 */
namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class RegisterModel extends Model{
    protected $table = 'account_regist';

    public $timestamps = true;
    protected $guarded = [];


}