<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;
use App\All;

$factory->define(All::class, function (Faker $faker) {
    return [
        //
        // 'user_id' => rand(1, 4),
        // 'position_id' => rand(1, 4),
        // 'team_id' => rand(1, 4),
        // 'era_id' => rand(1, 4),
        // 'user_id' => function() {
        //     return factory(User::class)->create()->id;
        // },
        'user_id' => factory(User::class),
        'position_id' => 1,
        'team_id' => 1,
        'era_id' => 1,
    ];
});
