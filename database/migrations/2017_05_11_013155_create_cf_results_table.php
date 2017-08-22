<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCfResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cf_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->integer('cfid')->nullable();//任务id
            $table->integer('oid')->nullable();//退款订单id
            $table->char('asin',24)->default('');//购买的asin
            $table->char('shop_id',20)->default('');//店铺id
            // 亚马逊
            $table->char('amazon_email',50)->default('');//亚马逊账号邮箱
            $table->char('amazon_orderid',50)->default('');//亚马逊订单号
            $table->char('amazon_logistics_company',50)->default('');//亚马逊物流供应商
            $table->char('amazon_logistics_orderid',50)->default('');//亚马逊物流单号

            $table->tinyInteger('star')->default(1);//星级
            $table->char('title',64)->default('');//标题
            $table->string('content',1024)->default('');//正文

            // 非业务字段
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('estatus')->default(1);

            $table->timestamps();

            //索引
            $table->index('uid');
            $table->index('oid');
            $table->index('cfid');
            $table->index('status');
            $table->index('asin','status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cf_results');
    }
}
