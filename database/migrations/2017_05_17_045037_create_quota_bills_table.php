<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotaBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quota_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->tinyInteger('type')->default(1);//消费类型 1 充值  2 刷单任务结果评价
            $table->integer('in')->default(0);//收入
            $table->integer('out')->default(0);//支出
            $table->integer('quota')->default(0);//余额
            $table->integer('taskid')->default(0);//充值记录id / 刷单任务结果记录id
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
        Schema::dropIfExists('quota_bills');
    }
}
