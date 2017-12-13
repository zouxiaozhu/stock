<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createUser();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('developer');

    }

    private function createUser()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('password');
            $table->string('email')->default('');
            $table->integer('phone')->default(0);
            $table->integer('create_user_id')->nullable();
            $table->enum('locked',[0,1])->default(0);
            $table->tinyInteger('reset_pwd')->default(0);
            $table->string('access_id')->default('')->comment("");
            $table->string('access_token')->default('')->comment("");
            $table->enum('is_develop',[0,1])->default(0)->comment("");
            $table->string('last_login_time')->default(time())->nullable();
            $table->string('avatar')->default('');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
