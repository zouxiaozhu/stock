<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createChart();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

//   $table->string('type')->comment('业务类型 jinshu,waihui,qihuo,jiaochapan')->default(0);
    public function createChart()
    {
        Schema::create('jinshu_chart', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->increments('id')->comment('chart_id');
            $table->string('year')->comment('')->default(0);
            $table->string('name')->comment('')->default(0);
            $table->string('key')->comment('')->default(0);
            $table->string('day')->comment('')->default(0);
            $table->string('month')->comment('')->default(0);
            $table->string('week')->comment('')->default(0);
            $table->string('now_top')->comment('')->default(0);
            $table->string('now_bottom')->comment('')->default(0);
            $table->string('top')->comment('')->default(0);
            $table->string('bottom')->comment('')->default(0);
            $table->timestamps();
        });

        Schema::create('waihui_chart', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->string('year')->comment('')->default(0);
            $table->increments('id')->comment('chart_id');
            $table->string('name')->comment('')->default(0);
            $table->string('key')->comment('')->default(0);
            $table->string('day')->comment('')->default(0);
            $table->string('month')->comment('')->default(0);
            $table->string('week')->comment('')->default(0);
            $table->string('now_top')->comment('')->default(0);
            $table->string('now_bottom')->comment('')->default(0);
            $table->string('top')->comment('')->default(0);
            $table->string('bottom')->comment('')->default(0);
            $table->timestamps();
        });

        Schema::create('qihuo_chart', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->string('year')->comment('')->default(0);
            $table->increments('id')->comment('chart_id');
            $table->string('name')->comment('')->default(0);
            $table->string('day')->comment('')->default(0);
            $table->string('key')->comment('')->default(0);
            $table->string('week')->comment('')->default(0);
            $table->string('month')->comment('')->default(0);
            $table->string('now_top')->comment('')->default(0);
            $table->string('now_bottom')->comment('')->default(0);
            $table->string('top')->comment('')->default(0);
            $table->string('bottom')->comment('')->default(0);
            $table->timestamps();
        });

        Schema::create('jiaochapan_chart', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->string('year')->comment('')->default(0);
            $table->increments('id')->comment('chart_id');
            $table->string('key')->comment('')->default(0);
            $table->string('name')->comment('')->default(0);
            $table->string('day')->comment('')->default(0);
            $table->string('month')->comment('')->default(0);
            $table->string('week')->comment('')->default(0);
            $table->string('now_top')->comment('')->default(0);
            $table->string('now_bottom')->comment('')->default(0);
            $table->string('top')->comment('')->default(0);
            $table->string('bottom')->comment('')->default(0);
            $table->timestamps();
        });
    }
}
