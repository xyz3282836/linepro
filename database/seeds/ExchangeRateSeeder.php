<?php

use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
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
                'name'    => 'USD',
                'apirate' => '6',
                'rate'    => '6'
            ],
            [
                'id'      => 2,
                'apiname' => 'CAD',
                'name'    => 'CAD',
                'apirate' => '6',
                'rate'    => '6'
            ],
            [
                'id'      => 3,
                'apiname' => 'GBP',
                'name'    => 'GBP',
                'apirate' => '6',
                'rate'    => '6'
            ],
            [
                'id'      => 4,
                'apiname' => 'EUR',
                'name'    => 'EUR',
                'apirate' => '6',
                'rate'    => '6'
            ],
            [
                'id'      => 5,
                'apiname' => 'JPY',
                'name'    => 'JPY',
                'apirate' => '6',
                'rate'    => '6'
            ]
        ]);
    }
}
