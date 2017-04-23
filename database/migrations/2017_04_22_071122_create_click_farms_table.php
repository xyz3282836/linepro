<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClickFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_farms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id
            $table->tinyInteger('platform_type')->default(1);//平台
            $table->char('asin',24)->default('');//购买的asin
            $table->tinyInteger('is_fba');//是否FBA发货
            $table->char('discount_code',24)->nullable();//优惠码
            $table->decimal('final_price',10,2)->default(0.00);//最终价格
            $table->tinyInteger('is_reviews')->default(2);//是否需要reviews 0:no 1:yes 2:Uncertain
            $table->char('specified_asin',24)->nullable();//指定曾经购买的asin
            $table->char('contrast_asin',100)->default('');//对比asin
            $table->tinyInteger('brower')->default(1);//浏览深度 1:适度浏览 2:深度浏览
            $table->tinyInteger('priority')->default(1);//优先选择 1:正常随机 2:不刷广告 3:只刷广告
            $table->tinyInteger('flow_port')->default(1);//流量端口 1:pc 2:移动
            $table->tinyInteger('flow_source')->default(1);//流量来源 1:正常 2:进A买B
            $table->tinyInteger('browse_step')->default(1);//浏览步骤 1:关键词 2:分类挑选 3:其他网站跳转

            $table->string('mixdata',500);//json
            //$table->json('mixdata');//json

            $table->integer('task_num')->default(1);//刷单件数
            $table->dateTime('start_time');//刷单开始时间
            $table->tinyInteger('interval_time')->default(1); // 刷单间隔
            $table->string('customer_message',500)->default('');//客户留言

            // 非业务字段
            $table->char('amazon_orderid',50)->default('');//亚马逊订单号
            $table->char('logistics_company',50)->default('');//物流公司
            $table->char('logistics_num',50)->default('');//物流订单

            $table->char('orderid',24)->default('');//订单号
            $table->tinyInteger('status')->default(1);//状态 1:待支付 2:已经支付 3:找寻买家中 4:买家找到，等待开始时间到 5:购买完成
            $table->decimal('amount',10,2)->default(0.00);//消费金额
            $table->timestamps();

            //索引
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
        Schema::dropIfExists('click_farms');
    }
}
