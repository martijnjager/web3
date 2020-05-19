<?php

use Illuminate\Database\Seeder;

class UserProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = \App\User::all()->where('role_id', 3);
        $developers = \App\User::all()->where('role_id', 2);

        \App\Project::all()->each(function ($project) use ($client) {
            $project->user()->attach($client->random(1));
        });

        \App\Project::all()->each(function ($project) use ($developers) {
            $project->user()->attach($developers->random(rand(1, $developers->count())));
        });
    }
}
