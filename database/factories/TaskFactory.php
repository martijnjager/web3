<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Project;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'comment' => $faker->paragraph,
        'status_id' => 1,
        'moscow_id' => $faker->numberBetween(1, 4),
        'check' => 0,
        'planned_time' => $faker->time(),
        'project_id' => $faker->numberBetween(1, (new Project())->get()->count()),
        'start_date' => $faker->dateTimeBetween(new Carbon(), (new Carbon())->addDays(5)),
        'end_date' => $faker->dateTimeBetween((new Carbon())->addDays(1), (new Carbon())->addDays(10)),
        'user_id' => $faker->numberBetween(1, 25),
    ];
});
