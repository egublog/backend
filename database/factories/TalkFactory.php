<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Talk;
use Illuminate\Support\Str;
use App\User;


$factory->define(Talk::class, function (Faker $faker) {
    return [
        //
        'talk_data' => Str::random(20),
        'from' => factory(User::class),
        'to' => factory(User::class),
        'yet' => false,
        'talkCheck' => false,
    ];
});
