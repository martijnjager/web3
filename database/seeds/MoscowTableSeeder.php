<?php

use Illuminate\Database\Seeder;

class MoscowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moscow = ['must', 'should', 'could', 'would'];

        foreach ($moscow as $m) {
            DB::table('moscow')->insert([
                'value' => $m
            ]);
        }
    }
}
