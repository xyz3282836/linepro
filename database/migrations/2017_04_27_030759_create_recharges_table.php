<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->tinyInteger('type')->default(1);//充值类型 1 支付宝
            $table->char('orderid',50)->default('');//订单号
            $table->decimal('amount',10,2)->default(0.00);//充值金额
            $table->char('name',10)->default('');//名字
            $table->char('mobile',11)->default('');//名字
            $table->tinyInteger('status')->default(0);// 0 未审核 1 通过 -1 不通过
            $table->dateTime('recharge_time');//充值时间
            $table->char('feedback',50)->default('');//充值反馈
            $table->timestamps();

            $table->index('uid');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recharges');
    }
}
