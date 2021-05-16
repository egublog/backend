<?php

namespace Tests;


use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;
use App\All;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function notLoginUser(User $user = null)
    {
        $user = $user ?? factory(User::class)->create();
        for ($i = 1; $i < 5; $i++) {
            factory(All::class)->create([
                'user_id' => $user->id,
                'era_id' => $i,
            ]);
        }

        return $user;
    }

    public function loginUser(User $user = null)
    {
        $user = $user ?? factory(User::class)->create();
        for ($i = 1; $i < 5; $i++) {
            factory(All::class)->create([
                'user_id' => $user->id,
                'era_id' => $i,
            ]);
        }

        $this->actingAs($user);

        return $user;
    }

    public function followSomeonesAccount($someonesAccount)
    {
        return $this->post(route('follows.store'), ['user_id' => $someonesAccount->id]);
    }







}
