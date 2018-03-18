<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/11
 * Time: 0:20
 */
namespace App\Http\Models\Backend;
class AnalyModel extends \Illuminate\Database\Eloquent\Model{
    protected $table = 'analy';

    public $timestamps = true;
    protected $guarded = [];

    public function getAttribute($value)
    {

    }
}