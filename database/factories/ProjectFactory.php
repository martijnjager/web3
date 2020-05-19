<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Project::class, function (Faker $faker) {
    $carbon = new Carbon();
    $carbon = $carbon->subDays(345);
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'start_time' => $faker->dateTime,
        'deadline' => $faker->dateTimeBetween($carbon, $carbon->addDays($faker->numberBetween(1, 500))),
        'planned_time' => rand(1, 23) . ":00:00",
    ];
});
