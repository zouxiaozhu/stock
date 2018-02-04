<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/4
 * Time: 12:34
 */
namespace App\Http\Models\Backend;
class DownloadModel extends  \Illuminate\Database\Eloquent\Model{

    protected $table = 'file_download';

    public $timestamps = true;
    protected $guarded = [];

    public function __construct()
    {
        parent::__construct();
    }
}