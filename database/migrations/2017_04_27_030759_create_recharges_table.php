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
            $table->char('orderid',30)->default('');//订单号
            $table->char('alipay_orderid',64)->default('');//订单号
            $table->decimal('amount',10,2)->default(0.00);//充值金额
            $table->decimal('rate')->default(0.00);//rmb-gold
            $table->integer('golds')->default(0);//等价金币
            $table->tinyInteger('status')->default(0);// 0 未审核 1 通过 -1 不通过
            $table->char('feedback',50)->default('');//充值反馈
            $table->timestamps();

            $table->index('uid');
            $table->index('status');
            $table->unique('orderid');
            $table->index('alipay_orderid');
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
