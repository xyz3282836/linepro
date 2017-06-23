<?php

use Illuminate\Database\Seeder;

class GconfigsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('gconfigs')->delete();

        \DB::table('gconfigs')->insert([
            0  =>
                [
                    'id'    => 1,
                    'key'   => 'site.overview1',
                    'desc'  => '统计代码1',
                    'value' => '',
                ],
            1  =>
                [
                    'id'    => 2,
                    'key'   => 'site.overview2',
                    'desc'  => '统计代码2',
                    'value' => '',
                ],
            2  =>
                [
                    'id'    => 3,
                    'key'   => 'site.name',
                    'desc'  => '站点名称',
                    'value' => 'LinePro',
                ],
            3  =>
                [
                    'id'    => 4,
                    'key'   => 'seo.keywords',
                    'desc'  => 'seo的keywords',
                    'value' => 'dagobuy',
                ],
            4  =>
                [
                    'id'    => 5,
                    'key'   => 'seo.description',
                    'desc'  => 'seo的description',
                    'value' => 'dagobuy',
                ],
            5  =>
                [
                    'id'    => 6,
                    'key'   => 'seo.author',
                    'desc'  => 'seo的author',
                    'value' => 'dagobuy',
                ],
            6  =>
                [
                    'id'    => 7,
                    'key'   => 'rmbtogold',
                    'desc'  => '人名币兑换金币',
                    'value' => '100',
                ],
            7  =>
                [
                    'id'    => 8,
                    'key'   => 'registergold',
                    'desc'  => '注册送金币',
                    'value' => '10000',
                ],
            8  =>
                [
                    'id'    => 9,
                    'key'   => 'regular.evaluate',
                    'desc'  => '普通会员评价权重',
                    'value' => '0',
                ],
            9  =>
                [
                    'id'    => 10,
                    'key'   => 'vip.evaluate',
                    'desc'  => '认证会员评价权重',
                    'value' => '0',
                ],
            10 =>
                [
                    'id'    => 11,
                    'key'   => 'regular.service.one.rate',
                    'desc'  => '普通会员限时下单服务费率',
                    'value' => '0.2',
                ],
            11 =>
                [
                    'id'    => 12,
                    'key'   => 'regular.service.three.rate',
                    'desc'  => '普通会员普通下单服务费率',
                    'value' => '0.15',
                ],
            12 =>
                [
                    'id'    => 13,
                    'key'   => 'regular.service.one.min',
                    'desc'  => '普通会员限时下单最少金币',
                    'value' => '2000',
                ],
            13 =>
                [
                    'id'    => 14,
                    'key'   => 'regular.service.three.min',
                    'desc'  => '普通会员普通下单最少金币',
                    'value' => '1500',
                ],
            14 =>
                [
                    'id'    => 15,
                    'key'   => 'vip.service.one.rate',
                    'desc'  => '认证会员限时下单服务费率',
                    'value' => '0.13',
                ],
            15 =>
                [
                    'id'    => 16,
                    'key'   => 'vip.service.three.rate',
                    'desc'  => '认证会员普通下单服务费率',
                    'value' => '0.1',
                ],
            16 =>
                [
                    'id'    => 17,
                    'key'   => 'vip.service.one.min',
                    'desc'  => '认证会员限时下单最少金币',
                    'value' => '1300',
                ],
            17 =>
                [
                    'id'    => 18,
                    'key'   => 'vip.service.three.min',
                    'desc'  => '认证会员普通下单最少金币',
                    'value' => '1000',
                ],
            18 =>
                [
                    'id'    => 19,
                    'key'   => 'cost.transport',
                    'desc'  => '转运费',
                    'value' => '350',
                ],
            19 =>
                [
                    'id'    => 20,
                    'key'   => 'cost.vip',
                    'desc'  => '会员费',
                    'value' => '1000',
                ],
            20 =>
                [
                    'id'    => 21,
                    'key'   => 'vip.days',
                    'desc'  => '会员时间',
                    'value' => '30',
                ],
        ]);


    }
}