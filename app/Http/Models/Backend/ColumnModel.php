<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/20
 * Time: 22:39
 */
namespace App\Http\Models\Backend;
use Illuminate\Database\Eloquent\Model;

class ColumnModel extends Model {
    protected $table = 'column';
    public $timestamps = true;
    protected $guarded = [];

}