<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;
use App\Follow;

$factory->define(Follow::class, function (Faker $faker) {
    return [
        //
        'send_user_id' => factory(User::class),
        'receive_user_id' => factory(User::class),
    ];
});
