<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoldBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gold_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->tinyInteger('type')->default(1);//消费类型 1 充值  2 代购任务消费
            $table->char('orderid',30)->default('');//订单号
            $table->integer('in')->default(0);//收入
            $table->integer('out')->default(0);//支出
            $table->integer('golds')->default(0);//金币余额
            $table->integer('taskid')->default(0);//
            $table->timestamps();

            $table->index('uid');
            $table->unique('orderid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gold_bills');
    }
}
