<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Talk_list;
use App\User;

$factory->define(Talk_list::class, function (Faker $faker) {
    return [
        //
        'from' => factory(User::class),
        'to' => factory(User::class),
    ];
});
