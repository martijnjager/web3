<?php

use Faker\Generator as Faker;
use App\Task;
use Carbon\Carbon;

$factory->define(App\Timer::class, function (Faker $faker) {

    $carbon = Carbon::now()->addHours($faker->numberBetween(0, 5))->addMinutes($faker->numberBetween(1, 20))->addSeconds($faker->numberBetween(0, 50));
    return [
        'start_time' => Carbon::now(),
        'end_time' => $carbon,
        'task_id' => $faker->numberBetween(1, (new Task())->get()->count()),
    ];
});
