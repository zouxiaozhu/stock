<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 23:21
 */

namespace App\Http\Models\Backend;
use Illuminate\Database\Eloquent\Model;

class MembersModel extends Model{
    protected $table='members';
    public $timestamps = true;
    protected $guarded = [];

}