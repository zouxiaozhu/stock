<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/27
 * Time: 23:39
 */

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class AceModel extends Model
{
    protected $table = 'ace';
    public $timestamps = false;
    protected $guarded = [];

}