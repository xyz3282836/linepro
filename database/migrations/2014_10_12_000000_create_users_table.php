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
            $table->tinyInteger('level')->default(1); // 1 普通用户 2 年费用户
            $table->decimal('amount',10,2)->default(0.00);//总金额
            $table->char('shop_id',20)->default('');//店铺id
            $table->char('mobile',15)->default('');
            $table->char('addr',50)->default('');
            $table->tinyInteger('management_type')->default(0);
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
