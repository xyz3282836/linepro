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
            $table->tinyInteger('type')->default(1);//消费类型
            $table->char('orderid',30)->default('');//订单号
            $table->char('alipay_orderid',64)->default('');//订单号
            $table->decimal('in',10,2)->default(0.00);//收入
            $table->decimal('out',10,2)->default(0.00);//支出
            $table->integer('gin')->default(0);//金币收入
            $table->integer('gout')->default(0);//金币支出
            $table->integer('oid')->default(0);//订单id
            $table->decimal('rate')->default(0.00);//rmb-gold
            $table->timestamps();

            $table->index('uid');
            $table->index('oid');
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
        Schema::dropIfExists('bills');
    }
}
