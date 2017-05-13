<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',15);
            $table->char('email',50)->unique();
            $table->string('password');
            $table->tinyInteger('level')->default(1); // 1 普通会员 2 认证会员
            $table->decimal('amount',10,2)->default(0.00);//总金额
            $table->integer('quota')->default(0);//配额
            $table->char('mobile',15)->default('');
            $table->char('addr',50)->default('');//联系地址
            $table->char('shipping_addr',50)->default('');//发货地址
            $table->char('real_name',6)->default('');//真实姓名
            $table->char('idcardno',18)->default('');//身份证号码
            $table->char('idcardpic',100)->default('');//身份证图片 正反
            $table->tinyInteger('management_type')->default(0);
            $table->dateTime('validity')->nullable();//认证会员有效期
            $table->rememberToken();
            $table->timestamps();

            $table->index('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
