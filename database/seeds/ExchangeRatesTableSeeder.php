<?php

use Illuminate\Database\Seeder;

class ExchangeRatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('exchange_rates')->delete();

        \DB::table('exchange_rates')->insert([
            0 =>
                [
                    'id'         => 1,
                    'apiname'    => 'USD',
                    'name'       => '$',
                    'apirate'    => '6.79',
                    'rate'       => '6.89',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => NULL,
                ],
            1 =>
                [
                    'id'         => 2,
                    'apiname'    => 'CAD',
                    'name'       => 'C$',
                    'apirate'    => '5.13',
                    'rate'       => '5.23',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => NULL,
                ],
            2 =>
                [
                    'id'         => 3,
                    'apiname'    => 'GBP',
                    'name'       => '£',
                    'apirate'    => '8.66',
                    'rate'       => '8.76',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => NULL,
                ],
            3 =>
                [
                    'id'         => 4,
                    'apiname'    => 'EUR',
                    'name'       => '€',
                    'apirate'    => '7.61',
                    'rate'       => '7.71',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => NULL,
                ],
            4 =>
                [
                    'id'         => 5,
                    'apiname'    => 'JPY',
                    'name'       => 'JPY¥',
                    'apirate'    => '0.06',
                    'rate'       => '0.16',
                    'created_at' => '2017-06-23 05:47:24',
                    'updated_at' => NULL,
                ],
        ]);


    }
}