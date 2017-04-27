<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);//用户id

            $table->tinyInteger('platform_type')->default(1);//平台
            $table->char('asin',24)->default('');//购买的asin
            $table->tinyInteger('is_direct')->default(0);//是否直评
            $table->integer('cfid')->default(0);//任务id
            $table->tinyInteger('star')->default(1);//星级
            $table->char('title',64)->default('');//标题
            $table->string('content',1024)->default('');//正文
            $table->string('pic',600)->default('');//图片
            $table->string('video',100)->default('');//视频
            $table->dateTime('start_time');//评价开始时间

            // 非业务字段
            $table->char('eid',50)->default('');//设置评价id用来展示
            $table->char('orderid',24)->default('');//订单号
            $table->tinyInteger('status')->default(1);//状态 0:取消订单 1:待支付 2:已经支付 3:找寻买家中 4:买家找到，等待开始时间到 5:评价完成
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
        Schema::dropIfExists('evaluates');
    }
}
