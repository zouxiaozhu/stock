<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('name')->commemt('名字')->unique();
            $table->string('key')->commemt('关键字')->dafault('');
            $table->integer('sort')->comment('')->dafault(0);
            $table->string('pic')->comment('pic');
            $table->enum('is_show',['0','1'])->comment('是否显示')->dafault(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column');
    }
}
