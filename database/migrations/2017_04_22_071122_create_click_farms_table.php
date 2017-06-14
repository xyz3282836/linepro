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
            $table->decimal('us_exchange_rate',3,1)->default(0.00);//美元对人名币汇率

            //3.0
            $table->tinyInteger('from_site')->default(1); // 来自站点
            $table->tinyInteger('time_type')->default(1); // 1:24小时 3:72小时
            $table->tinyInteger('delivery_type')->default(1);//1:自行转运 2:达购转运

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


            $table->char('orderid',30)->default('');//订单号
            $table->tinyInteger('status')->default(1);//状态 0:取消订单 1:待支付 2:已经支付 3:找寻买家中 4:买家找到，等待开始时间到 5:购买完成
            $table->decimal('transport',10,2)->default(0.00);//转运费
            $table->decimal('amount',10,2)->default(0.00);//消费金额
            $table->integer('golds')->default(0);//手续费金币
            $table->timestamps();

            //索引
            $table->index('uid');
            $table->index('status');
            $table->index('asin','status');
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
        Schema::dropIfExists('click_farms');
    }
}
