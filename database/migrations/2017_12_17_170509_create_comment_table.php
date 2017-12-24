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
//        Schema::create('posts', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('site_id')->comment('站点id')->default(1);
//            $table->integer('forum_id')->comment('板块');
//            $table->integer('order_id')->comment('排序ID')->default(0);
//            $table->integer('fathers_id')->comment('所有的Father版块')->default(0);
//            $table->string('title',30)->comment('title');
//            $table->string('brief')->nullable()->comment('简介');
//            $table->text('content')->comment('内容');
//            $table->enum('type',['vote','tuwen'])->comment('创建人');
//            $table->string('address')->comment('发帖地址');
//            $table->string('longitude')->comment('经度');
//            $table->string('latitude')->comment('纬度');
//            $table->string('ip')->nullable()->comment('IP信息');
//            $table->enum('is_top',[0,1])->default(0)->comment('是否置顶');
//            $table->enum('is_essence',[0,1])->default(0)->comment('是否精华');
//            $table->enum('status',[0,1,2])->default(1)->comment('0 删除 1 默认 2恢复');
//            $table->integer('comment_num')->comment('评论总数')->default(0);
//            $table->integer('like_num')->comment('点赞数')->default(0);
//            $table->integer('dislike_num')->comment('点踩数')->default(0);
//            $table->integer('share_num')->comment('分享次数')->default(0);
//            $table->timestamps();
//        });
    }
    public function createComment(){
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id')->comment('评论id');
            $table->integer('ace_id')->comment('帖子id');
            $table->integer('ace_comment_fid')->comment('主回复')->default(0);
            $table->string('reply_member_id')->comment('父级评论回复的会员名称')->nullable();
            $table->integer('member_id')->comment('会员id')->default(0);
            $table->integer('like_num')->comment('点赞数')->default(0);
            $table->integer('dislike_num')->comment('反对数')->default(0);
            $table->enum('status',[0,1,2,3])->comment('0被删除 1正常 3 待审核 2已恢复')->nullable();
            $table->timestamps();
        });
    }
}
