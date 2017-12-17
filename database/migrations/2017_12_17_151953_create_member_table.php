<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createMember();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    protected function createMember(){
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('password')->nullable();
            $table->string('nick_name')->comment('昵称')->default('');
            $table->enum('source',[1,2])->comment('来源 1 微信 2 facebook');
            $table->string('email')->default('');
            $table->integer('credits')->comment('会员总积分')->default(0);
            $table->string('type')->comment('会员类型')->default('1');
            $table->tinyInteger('group_id')->comment('会员分组id')->default(0)->unsigned()->index();
            $table->string('signature')->comment('个性签名')->default('');
            $table->integer('phone')->default(0);
            $table->enum('status', [0, 1])->comment('状态，0禁用，1活跃')->default(1);
            $table->string('open_id')->default('')->comment("");
            $table->string('last_login_time')->default(date("Y-m-d,H:i:s",time()))->nullable();
            $table->string('avatar')->default('');
            $table->string('last_login_device_type')->comment('登录设备ios,web,android')->index()->default('');
            $table->timestamps();
        });
    }
}
