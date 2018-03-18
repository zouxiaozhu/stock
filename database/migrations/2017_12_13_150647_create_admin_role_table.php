<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字');
            $table->enum('super_admin', [0, 1])->default(0);
            $table->string('description', 100)->default('');
            $table->timestamps();
        });

        Schema::create('auths', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->char('name', 10)->commemt('名字')->default('');
            $table->string('prm')->comment('标识');
            $table->timestamps();
        });

        Schema::create('role_auth', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('role_id')->commemt('名字')->default(0);
            $table->integer('auth_id')->comment('')->default(0);
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');
            $table->timestamps();
//            $table->primary(['role_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('auths');
    }


}
