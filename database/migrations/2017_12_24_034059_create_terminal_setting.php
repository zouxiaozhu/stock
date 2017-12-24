<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminal_settings', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id');
            $table->string('name',25)->comment('设置名称')->default('');
            $table->string('key',25)->comment('标识')->default('');
            $table->string('value')->comment('设置值')->default(0);
            $table->enum('type',[1,2])->comment('类型 1 number  2text');
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
        //
    }
}
