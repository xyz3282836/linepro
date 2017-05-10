<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vp_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->integer('rid')->default(0);//充值记录id
            $table->smallInteger('days')->default(0);//加的天数
            $table->dateTime('validity')->nullable();//统计到哪天
            $table->timestamps();

            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vp_bills');
    }
}
