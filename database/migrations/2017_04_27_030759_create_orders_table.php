<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->tinyInteger('type')->default(1);//订单类型 1 充值 2 消费 3退款
            $table->tinyInteger('payment_type')->default(1);//充值类型 1 支付宝
            $table->char('orderid',30)->default('');//订单号
            $table->char('alipay_orderid',64)->default('');//订单号

            $table->decimal('balance',10,2)->default(0.00);//余额
            $table->decimal('price',10,2)->default(0.00);//金额
            $table->integer('golds')->default(0);//金币
            $table->decimal('rate')->default(0.00);//rmb-gold

            $table->tinyInteger('status')->default(0);// 0 待付款 1 通过 -1 不通过
            $table->timestamps();

            $table->index('uid');
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
