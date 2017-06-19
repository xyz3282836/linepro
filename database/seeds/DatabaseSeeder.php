<?php

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
        DB::table('exchange_rates')->insert([
            [
                'id'      => 1,
                'apiname' => 'USD',
                'name'    => '$',
                'apirate' => '6.79',
                'rate'    => '6.89'
            ],
            [
                'id'      => 2,
                'apiname' => 'CAD',
                'name'    => 'C$',
                'apirate' => '5.13',
                'rate'    => '5.23'
            ],
            [
                'id'      => 3,
                'apiname' => 'GBP',
                'name'    => '£',
                'apirate' => '8.66',
                'rate'    => '8.76'
            ],
            [
                'id'      => 4,
                'apiname' => 'EUR',
                'name'    => '€',
                'apirate' => '7.61',
                'rate'    => '7.71'
            ],
            [
                'id'      => 5,
                'apiname' => 'JPY',
                'name'    => 'JPY¥',
                'apirate' => '0.06',
                'rate'    => '0.16'
            ]
        ]);
        DB::table('gconfigs')->insert([
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
                'desc'  => '评价权重',
                'value' => '0',
            ],
            [
                'key'   => 'vip.evaluate',
                'desc'  => '评价权重',
                'value' => '0',
            ],

            [
                'key'   => 'regular.service.one.rate',
                'desc'  => '服务费率',
                'value' => '0.2',
            ],
            [
                'key'   => 'regular.service.three.rate',
                'desc'  => '服务费率',
                'value' => '0.15',
            ],
            [
                'key'   => 'regular.service.one.min',
                'desc'  => '',
                'value' => '2000',
            ],
            [
                'key'   => 'regular.service.three.min',
                'desc'  => '',
                'value' => '1500',
            ],
            [
                'key'   => 'vip.service.one.rate',
                'desc'  => '服务费率',
                'value' => '0.13',
            ],
            [
                'key'   => 'vip.service.three.rate',
                'desc'  => '服务费率',
                'value' => '0.1',
            ],
            [
                'key'   => 'vip.service.one.min',
                'desc'  => '',
                'value' => '1300',
            ],
            [
                'key'   => 'vip.service.three.min',
                'desc'  => '',
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
    }
}