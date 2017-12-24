<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24
 * Time: 15:58
 */
namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\ApiAuth\ApiAuthTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller{
    use ApiAuthTrait;
    protected $access_token;
    public function __construct(Request $request)
    {
        $this->access_token = trim($request->get('access_token'));
    }
    public function addComment(Request $request){
        $member_info = $this->decode_access_token($this->access_token);
        var_export($member_info);die;


    }

}