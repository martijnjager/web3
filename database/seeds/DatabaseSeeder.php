<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             MoscowTableSeeder::class,
             StatusTableSeeder::class,
             RoleTableSeeder::class,
             ProjectTableSeeder::class,
             UsersTableSeeder::class,
             TaskTableSeeder::class,
             UserProjectTableSeeder::class,

         ]);
    }
}
