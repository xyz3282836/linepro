<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('admin_menu')->delete();

        \DB::table('admin_menu')->insert([
            0  =>
                [
                    'id'         => 1,
                    'parent_id'  => 0,
                    'order'      => 1,
                    'title'      => 'Index',
                    'icon'       => 'fa-bar-chart',
                    'uri'        => '/',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            1  =>
                [
                    'id'         => 2,
                    'parent_id'  => 0,
                    'order'      => 2,
                    'title'      => 'Admin',
                    'icon'       => 'fa-tasks',
                    'uri'        => '',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            2  =>
                [
                    'id'         => 3,
                    'parent_id'  => 2,
                    'order'      => 3,
                    'title'      => 'Users',
                    'icon'       => 'fa-users',
                    'uri'        => 'auth/users',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            3  =>
                [
                    'id'         => 4,
                    'parent_id'  => 2,
                    'order'      => 4,
                    'title'      => 'Roles',
                    'icon'       => 'fa-user',
                    'uri'        => 'auth/roles',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            4  =>
                [
                    'id'         => 5,
                    'parent_id'  => 2,
                    'order'      => 5,
                    'title'      => 'Permission',
                    'icon'       => 'fa-user',
                    'uri'        => 'auth/permissions',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            5  =>
                [
                    'id'         => 6,
                    'parent_id'  => 2,
                    'order'      => 6,
                    'title'      => 'Menu',
                    'icon'       => 'fa-bars',
                    'uri'        => 'auth/menu',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            6  =>
                [
                    'id'         => 7,
                    'parent_id'  => 2,
                    'order'      => 7,
                    'title'      => 'Operation log',
                    'icon'       => 'fa-history',
                    'uri'        => 'auth/logs',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            7  =>
                [
                    'id'         => 8,
                    'parent_id'  => 0,
                    'order'      => 8,
                    'title'      => 'Helpers',
                    'icon'       => 'fa-gears',
                    'uri'        => '',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            8  =>
                [
                    'id'         => 9,
                    'parent_id'  => 8,
                    'order'      => 9,
                    'title'      => 'Scaffold',
                    'icon'       => 'fa-keyboard-o',
                    'uri'        => 'helpers/scaffold',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            9  =>
                [
                    'id'         => 10,
                    'parent_id'  => 8,
                    'order'      => 10,
                    'title'      => 'Database terminal',
                    'icon'       => 'fa-database',
                    'uri'        => 'helpers/terminal/database',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            10 =>
                [
                    'id'         => 11,
                    'parent_id'  => 8,
                    'order'      => 11,
                    'title'      => 'Laravel artisan',
                    'icon'       => 'fa-terminal',
                    'uri'        => 'helpers/terminal/artisan',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            11 =>
                [
                    'id'         => 12,
                    'parent_id'  => 0,
                    'order'      => 12,
                    'title'      => '前台配置',
                    'icon'       => 'fa-cogs',
                    'uri'        => '',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            12 =>
                [
                    'id'         => 13,
                    'parent_id'  => 12,
                    'order'      => 13,
                    'title'      => '业务参数',
                    'icon'       => 'fa-cog',
                    'uri'        => 'config',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            13 =>
                [
                    'id'         => 14,
                    'parent_id'  => 12,
                    'order'      => 14,
                    'title'      => 'Faq',
                    'icon'       => 'fa-question-circle',
                    'uri'        => 'faq',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
            14 =>
                [
                    'id'         => 15,
                    'parent_id'  => 12,
                    'order'      => 15,
                    'title'      => '轮播图',
                    'icon'       => 'fa-picture-o',
                    'uri'        => 'banner',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ],
        ]);


    }
}