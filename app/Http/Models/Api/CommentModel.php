<?php
namespace App\Http\Models\Api;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model{

    protected $table = 'comments';
    public $timestamps = true;
    protected $guarded = [];

}