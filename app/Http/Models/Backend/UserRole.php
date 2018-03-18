<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/13
 * Time: 23:37
 */
namespace App\Http\Models\Backend;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model{
    protected $table = 'user_role';
    public $timestamps = true;
}