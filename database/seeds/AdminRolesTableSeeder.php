<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('admin_roles')->delete();

        \DB::table('admin_roles')->insert([
            0 =>
                [
                    'id'         => 1,
                    'name'       => '超级管理员',
                    'slug'       => 'administrator',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => '2017-06-23 05:47:24',
                ],
            1 =>
                [
                    'id'         => 2,
                    'name'       => '后台管理员',
                    'slug'       => 'admin',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => '2017-06-23 05:47:24',
                ],
        ]);


    }
}