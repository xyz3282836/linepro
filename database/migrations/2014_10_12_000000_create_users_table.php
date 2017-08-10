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
            $table->char('name', 15);
            $table->char('email', 50)->unique();
            $table->string('password');
            $table->tinyInteger('level')->default(1); // 1 普通会员 2 认证会员
            $table->decimal('balance', 10, 2)->default(0.00);//余额
            $table->decimal('lock_balance', 10, 2)->default(0.00);//余额
            $table->integer('golds')->default(0);//金币余额
            $table->integer('lock_golds')->default(0);//金币余额
            $table->char('mobile', 15)->default('');
            $table->char('addr', 50)->default('');//联系地址
            $table->char('shipping_addr', 50)->default('');//发货地址
            $table->char('real_name', 6)->default('');//真实姓名
            $table->char('idcardno', 18)->default('');//身份证号码
            $table->char('idcardpic', 100)->default('');//身份证图片 正反
            $table->tinyInteger('is_evaluate')->default(1);//是否禁止评价
            $table->dateTime('validity')->nullable();//认证会员有效期
            $table->rememberToken();
            $table->dateTime('last_login_time')->nullable();//上一次登入时间
            $table->timestamps();

            $table->index('level');
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
