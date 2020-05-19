<?php

use Faker\Generator as Faker;
use App\Project;
use App\User;

$factory->define(App\UserProject::class, function (Faker $faker) {
    return [
        'project_id' => $faker->numberBetween(1, (new Project())->get()->count()),
        'user_id' => $faker->numberBetween(1, (new Project())->get()->count())
    ];
});
