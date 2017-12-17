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
        $this->create_comment();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    public function create_comment(){
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id')->comment('评论回复id');
            $table->integer('column_id')->comment('栏目id');
            $table->integer('article_id')->comment('帖子id');
            $table->integer('post_fid')->comment('主回复')->default(0);
            $table->string('reply_member_id')->comment('父级评论回复的会员名称')->nullable();
            $table->integer('member_id')->comment('会员id')->default(0);
            $table->integer('like_num')->comment('点赞数')->default(0);
            $table->integer('dislike_num')->comment('反对数')->default(0);
            $table->enum('status',[0,1,2])->comment('0被删除 1正常 2已恢复')->nullable();
            $table->timestamps();
        });
    }
}
