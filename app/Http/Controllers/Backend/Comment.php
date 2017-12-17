<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/18
 * Time: 0:58
 */

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class Comment extends Controller{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function audit(){
        $column = $this->request->get('column_id');
        $article_id = $this->request->get('article_id');

    }
}