<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('admin_users')->delete();

        \DB::table('admin_users')->insert([
            0 =>
                [
                    'id'             => 1,
                    'username'       => 'dagogadmin',
                    'password'       => '$2y$10$5gcWCIVDm8D47ascZyX1.O0MYBFjltWdvwGs.3KTLLLQKNJhRfF4u',
                    'name'           => '超管就是我',
                    'avatar'         => NULL,
                    'remember_token' => NULL,
                    'created_at'     => '2017-06-23 05:47:24',
                    'updated_at'     => '2017-06-23 05:47:24',
                ],
            1 =>
                [
                    'id'             => 2,
                    'username'       => 'dagoadmin',
                    'password'       => '$2y$10$YiJ4RvWOgp50oiJJ1QL6LeLPSujkQEguN.gv7NGOTJNjHwjI3jlfW',
                    'name'           => 'Dago管理员',
                    'avatar'         => NULL,
                    'remember_token' => NULL,
                    'created_at'     => '2017-06-23 05:47:24',
                    'updated_at'     => '2017-06-23 05:47:24',
                ],
        ]);


    }
}