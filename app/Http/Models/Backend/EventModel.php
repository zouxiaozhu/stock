<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/14
 * Time: 17:03
namespace App\Http\Models; */
namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;
class EventModel extends Model{
    protected $primaryKey = 'event_id';
    protected $table = 'event';
    public $timestamps = true;
    protected $guarded = [];
}