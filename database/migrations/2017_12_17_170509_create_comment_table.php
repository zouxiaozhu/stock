<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createComment();
        $this->createPost();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
    /**
     * 发帖
     */
    public function createPost()
    {

    }
    // 0    1-财经日志  2 财经新闻 3 财经公告
    public function createComment(){
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id')->comment('评论id');
            $table->integer('type')->comment('帖子类型 0 - ace 1-财经日志  
            2 财经新闻 3 财经公告 4 经济数据  5市场焦点 6港股分析 7伦敦白银')->default(0);
            $table->integer('post_id')->comment('帖子id')->default(0);
            $table->integer('post_comment_fid')->comment('主回复')->default(0);
            $table->integer('reply_member_id')->comment('父级评论回复的会员ID')->default(0);
            $table->string('reply_member_name')->comment('父级评论回复的会员名称')->default(0);
            $table->integer('member_id')->comment('会员id')->default(0);
            $table->string('member_name')->comment('会员名称')->default(0);
            $table->string('content')->comment('内容')->default('');
            $table->integer('like_num')->comment('点赞数')->default(0);
            $table->integer('dislike_num')->comment('反对数')->default(0);
            $table->enum('status',[0,1,2])->comment('0被删除 1正常 2 待审核 ')->default(2);
            $table->timestamps();
        });
    }
}
