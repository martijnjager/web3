<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Martijn',
            'email' => 'martijn.jager@fontys.nl',
            'password' => bcrypt('martijn'),
            'role_id' => 1,
            'remember_token' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'Tester',
            'email' => 'tester@fontys.nl',
            'password' => bcrypt('tester'),
            'role_id' => 3,
            'remember_token' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'dev',
            'email' => 'dev@fontys.nl',
            'password' => bcrypt('dev'),
            'role_id' => 2,
            'remember_token' => Str::random(10),
        ]);

        factory(\App\User::class, 25)->create();
    }
}
