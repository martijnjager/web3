<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moscow = ['not started', 'running', 'finished'];

        foreach ($moscow as $m) {
            DB::table('status')->insert([
                'value' => $m
            ]);
        }
    }
}
