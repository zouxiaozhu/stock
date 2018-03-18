<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/5
 * Time: 22:32
 */
namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class FileModel extends Model{
    protected $table = 'file_upload';

    public $timestamps = true;
    protected $guarded = [];




}