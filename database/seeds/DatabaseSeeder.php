<?php

use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * php artisan db:seed
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert([
            [
                'type'       => 2,
                'title'      => 'logo',
                'pic'        => 'banner/logo.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'type'       => 1,
                'title'      => 'banner1',
                'pic'        => 'banner/banner1.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'type'       => 1,
                'title'      => 'banner2',
                'pic'        => 'banner/banner2.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'type'       => 1,
                'title'      => 'banner3',
                'pic'        => 'banner/banner3.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'type'       => 1,
                'title'      => 'banner4',
                'pic'        => 'banner/banner4.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'type'       => 3,
                'title'      => 'http://www.baidu.com',
                'pic'        => 'banner/adbnner1.png',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'type'       => 4,
                'title'      => 'http://www.baidu.com',
                'pic'        => 'banner/adbnner2.png',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
        DB::table('exchange_rates')->insert([
            [
                'id'         => 1,
                'apiname'    => 'USD',
                'name'       => '$',
                'apirate'    => '6.79',
                'rate'       => '6.89',
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 2,
                'apiname'    => 'CAD',
                'name'       => 'C$',
                'apirate'    => '5.13',
                'rate'       => '5.23',
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 3,
                'apiname'    => 'GBP',
                'name'       => '£',
                'apirate'    => '8.66',
                'rate'       => '8.76',
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 4,
                'apiname'    => 'EUR',
                'name'       => '€',
                'apirate'    => '7.61',
                'rate'       => '7.71',
                'created_at' => Carbon::now()
            ],
            [
                'id'         => 5,
                'apiname'    => 'JPY',
                'name'       => 'JPY¥',
                'apirate'    => '0.06',
                'rate'       => '0.16',
                'created_at' => Carbon::now()
            ]
        ]);
        DB::table('gconfigs')->insert([
            [
                'key'   => 'site.overview1',
                'desc'  => '统计代码1',
                'value' => '',
            ],
            [
                'key'   => 'site.overview2',
                'desc'  => '统计代码2',
                'value' => '',
            ],
            [
                'key'   => 'site.name',
                'desc'  => '站点名称',
                'value' => 'LinePro',
            ],
            [
                'key'   => 'seo.keywords',
                'desc'  => 'seo的keywords',
                'value' => 'dagobuy',
            ],
            [
                'key'   => 'seo.description',
                'desc'  => 'seo的description',
                'value' => 'dagobuy',
            ],
            [
                'key'   => 'seo.author',
                'desc'  => 'seo的author',
                'value' => 'dagobuy',
            ],
            [
                'key'   => 'rmbtogold',
                'desc'  => '人名币兑换金币',
                'value' => '100',
            ],
            [
                'key'   => 'registergold',
                'desc'  => '注册送金币',
                'value' => '10000',
            ],
            [
                'key'   => 'regular.evaluate',
                'desc'  => '普通会员评价权重',
                'value' => '0',
            ],
            [
                'key'   => 'vip.evaluate',
                'desc'  => '认证会员评价权重',
                'value' => '0',
            ],

            [
                'key'   => 'regular.service.one.rate',
                'desc'  => '普通会员限时下单服务费率',
                'value' => '0.2',
            ],
            [
                'key'   => 'regular.service.three.rate',
                'desc'  => '普通会员普通下单服务费率',
                'value' => '0.15',
            ],
            [
                'key'   => 'regular.service.one.min',
                'desc'  => '普通会员限时下单最少金币',
                'value' => '2000',
            ],
            [
                'key'   => 'regular.service.three.min',
                'desc'  => '普通会员普通下单最少金币',
                'value' => '1500',
            ],
            [
                'key'   => 'vip.service.one.rate',
                'desc'  => '认证会员限时下单服务费率',
                'value' => '0.13',
            ],
            [
                'key'   => 'vip.service.three.rate',
                'desc'  => '认证会员普通下单服务费率',
                'value' => '0.1',
            ],
            [
                'key'   => 'vip.service.one.min',
                'desc'  => '认证会员限时下单最少金币',
                'value' => '1300',
            ],
            [
                'key'   => 'vip.service.three.min',
                'desc'  => '认证会员普通下单最少金币',
                'value' => '1000',
            ],
            [
                'key'   => 'cost.transport',
                'desc'  => '转运费',
                'value' => '350',
            ],
            [
                'key'   => 'cost.vip',
                'desc'  => '会员费',
                'value' => '1000',
            ],
            [
                'key'   => 'vip.days',
                'desc'  => '会员时间',
                'value' => '30',
            ],
        ]);
        DB::table('faqs')->insert([
            [
                'id'         => 1,
                'q'          => '你们是什么平台？',
                'a'          => '我们是达购海外代购平台。',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username' => 'dagogadmin',
            'password' => bcrypt('dago8888'),
            'name'     => '超管就是我',
        ]);
        Administrator::create([
            'username' => 'dagoadmin',
            'password' => bcrypt('dago8888'),
            'name'     => 'Dago管理员',
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name' => '超级管理员',
            'slug' => 'administrator',
        ]);
        Role::create([
            'name' => '后台管理员',
            'slug' => 'admin',
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());
        Administrator::find(2)->roles()->save(Role::find(2));

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'Index',
                'icon'      => 'fa-bar-chart',
                'uri'       => '/',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => 'Admin',
                'icon'      => 'fa-tasks',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => 'Users',
                'icon'      => 'fa-users',
                'uri'       => 'auth/users',
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => 'Roles',
                'icon'      => 'fa-user',
                'uri'       => 'auth/roles',
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => 'Permission',
                'icon'      => 'fa-user',
                'uri'       => 'auth/permissions',
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => 'Menu',
                'icon'      => 'fa-bars',
                'uri'       => 'auth/menu',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => 'Operation log',
                'icon'      => 'fa-history',
                'uri'       => 'auth/logs',
            ],
            [
                'parent_id' => 0,
                'order'     => 8,
                'title'     => 'Helpers',
                'icon'      => 'fa-gears',
                'uri'       => '',
            ],
            [
                'parent_id' => 8,
                'order'     => 9,
                'title'     => 'Scaffold',
                'icon'      => 'fa-keyboard-o',
                'uri'       => 'helpers/scaffold',
            ],
            [
                'parent_id' => 8,
                'order'     => 10,
                'title'     => 'Database terminal',
                'icon'      => 'fa-database',
                'uri'       => 'helpers/terminal/database',
            ],
            [
                'parent_id' => 8,
                'order'     => 11,
                'title'     => 'Laravel artisan',
                'icon'      => 'fa-terminal',
                'uri'       => 'helpers/terminal/artisan',
            ],
            [
                'parent_id' => 0,
                'order'     => 12,
                'title'     => '前台配置',
                'icon'      => 'fa-cogs',
                'uri'       => '',
            ],
            [
                'parent_id' => 12,
                'order'     => 13,
                'title'     => '业务参数',
                'icon'      => 'fa-cog',
                'uri'       => 'config',
            ],
            [
                'parent_id' => 12,
                'order'     => 14,
                'title'     => 'Faq',
                'icon'      => 'fa-question-circle',
                'uri'       => 'faq',
            ],
            [
                'parent_id' => 12,
                'order'     => 15,
                'title'     => '图片设置',
                'icon'      => 'fa-picture-o',
                'uri'       => 'banner',
            ],
            [
                'parent_id' => 12,
                'order'     => 16,
                'title'     => '货币汇率',
                'icon'      => 'fa-dollar',
                'uri'       => 'rate',
            ],
            [
                'parent_id' => 0,
                'order'     => 17,
                'title'     => '网站数据',
                'icon'      => 'fa-database',
                'uri'       => '',
            ],
            [
                'parent_id' => 17,
                'order'     => 18,
                'title'     => '用户列表',
                'icon'      => 'fa-user',
                'uri'       => 'user',
            ],
            [
                'parent_id' => 17,
                'order'     => 19,
                'title'     => '订单列表',
                'icon'      => 'fa-reorder',
                'uri'       => 'order',
            ],
        ]);

        // add role to menu.
        Menu::find(2)->roles()->save(Role::first());
        Menu::find(8)->roles()->save(Role::first());

//        $this->call(BannersTableSeeder::class);
//        $this->call(ExchangeRatesTableSeeder::class);
//        $this->call(GconfigsTableSeeder::class);
//        $this->call(AdminUsersTableSeeder::class);
//        $this->call(AdminRolesTableSeeder::class);
//        $this->call(AdminMenuTableSeeder::class);
//        $this->call(AdminRoleUsersTableSeeder::class);
//        $this->call(AdminRoleMenuTableSeeder::class);
//        $this->call(FaqsTableSeeder::class);
    }
}