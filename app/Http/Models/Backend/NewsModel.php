<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/14
 * Time: 17:02
 */
namespace App\Http\Models\Backend;
class NewsModel extends  \Illuminate\Database\Eloquent\Model{
    protected $primaryKey = 'news_id';
    protected $table = 'news';
    public $timestamps = true;
    protected $guarded = [];


}