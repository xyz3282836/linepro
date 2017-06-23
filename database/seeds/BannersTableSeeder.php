<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('banners')->delete();

        \DB::table('banners')->insert([
            0 =>
                [
                    'id'         => 1,
                    'title'      => 'banner1',
                    'pic'        => 'banner/banner1.png',
                    'created_at' => '2017-06-23 03:43:25',
                    'updated_at' => '2017-06-23 04:44:31',
                ],
            1 =>
                [
                    'id'         => 2,
                    'title'      => 'banner2',
                    'pic'        => 'banner/banner2.png',
                    'created_at' => '2017-06-23 04:28:07',
                    'updated_at' => '2017-06-23 04:28:07',
                ],
            2 =>
                [
                    'id'         => 3,
                    'title'      => 'banner3',
                    'pic'        => 'banner/banner3.png',
                    'created_at' => '2017-06-23 04:45:26',
                    'updated_at' => '2017-06-23 04:45:26',
                ],
            3 =>
                [
                    'id'         => 4,
                    'title'      => 'banner4',
                    'pic'        => 'banner/banner4.png',
                    'created_at' => '2017-06-23 04:45:41',
                    'updated_at' => '2017-06-23 04:45:41',
                ],
        ]);


    }
}