<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->tinyInteger('type')->default(1);//消费类型 1 充值  2 刷单任务消费 3 评论任务消费
            $table->char('orderid',50)->default('');//订单号
            $table->decimal('in',10,2)->default(0.00);//收入
            $table->decimal('out',10,2)->default(0.00);//支出
            $table->decimal('amount',10,2)->default(0.00);//余额
            $table->integer('taskid')->default(0);//
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
        Schema::dropIfExists('bills');
    }
}
