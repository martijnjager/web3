<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'developer', 'client'];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'value' => $role
            ]);
        }
    }
}
