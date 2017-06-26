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
            $table->integer('oid')->default(0);//order-id

            //2.0
            $table->char('asin',24)->default('');//购买的asin
            $table->char('delivery_addr',50)->default('');//送货地址
            //amazon
            $table->string('amazon_url',500)->default('');//亚马逊详情页
            $table->string('amazon_pic',500)->default('');//亚马逊产品图片
            $table->char('amazon_title',50)->default('');//亚马逊产品title
            $table->char('shop_id',50)->default('');//店铺id
            $table->integer('task_num')->default(1);//刷单件数
            $table->decimal('final_price',10,2)->default(0.00);//美元价格
            $table->decimal('rate',10,2)->default(0.00);//外币汇率
            $table->decimal('srate',10,2)->default(0.00);//服务费率
            $table->decimal('grate',10,2)->default(0.00);//rmbtogold

            //3.0
            $table->tinyInteger('from_site')->default(1); // 来自站点
            $table->tinyInteger('time_type')->default(1); // 1:24小时 3:72小时
            $table->tinyInteger('delivery_type')->default(1);//1:自行转运 2:达购转运
            $table->char('shop_name',50)->default('');//1:自行转运 2:达购转运

            //1.0
            $table->tinyInteger('platform_type')->default(1);//平台

            $table->tinyInteger('is_fba');//是否FBA发货
            $table->char('discount_code',24)->nullable();//优惠码
            $table->tinyInteger('is_reviews')->default(0);//是否需要reviews 0:no 1:yes 2:Uncertain
            $table->tinyInteger('is_link')->default(0);//是否需要reviews 0:no 1:yes 2:Uncertain
            $table->tinyInteger('is_sellerrank')->default(0);//是否需要reviews 0:no 1:yes 2:Uncertain

            $table->char('specified_asin',24)->nullable();//指定曾经购买的asin
            $table->char('contrast_asin',100)->default('');//对比asin
            $table->tinyInteger('brower')->default(1);//浏览深度 1:适度浏览 2:深度浏览
            $table->tinyInteger('priority')->default(1);//优先选择 1:正常随机 2:不刷广告 3:只刷广告
            $table->tinyInteger('flow_port')->default(1);//流量端口 1:pc 2:移动
            $table->tinyInteger('flow_source')->default(1);//流量来源 1:正常 2:进A买B
            $table->tinyInteger('browse_step')->default(1);//浏览步骤 1:关键词 2:分类挑选 3:其他网站跳转

            $table->string('mixdata',500);//json
            //$table->json('mixdata');//json

            $table->dateTime('start_time');//刷单开始时间
            $table->tinyInteger('interval_time')->default(1); // 刷单间隔
            $table->string('customer_message',500)->default('');//客户留言

            $table->tinyInteger('status')->default(1);//状态 0:删除 1:有效 2:绑定订单
            $table->decimal('transport',10,2)->default(0.00);//转运费
            $table->decimal('amount',10,2)->default(0.00);//消费金额
            $table->integer('golds')->default(0);//手续费金币
            $table->timestamps();

            //索引
            $table->index('uid');
            $table->index('oid');
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
        Schema::dropIfExists('click_farms');
    }
}
