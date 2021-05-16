<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Team;
use Illuminate\Support\Str;


$factory->define(Team::class, function (Faker $faker) {
    return [
        //
        'team_name' => Str::random(10),
    ];
});
