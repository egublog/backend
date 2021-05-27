<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\Follow;
use App\User;


class ActivityControllerTest extends TestCase
{

    use RefreshDatabase;
    

    /** @test index */
    function ゲストはページを表示出来ない()
    {
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();
        $this->get(route('activities.index'))->assertRedirect($url);
        $someonesAccount = $this->notLoginUser();
        $this->get(route('activities.show', ['user' => $someonesAccount->id]))->assertRedirect($url);
    }


    /** @test index */
    function activitiesのindexを表示できる()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = $this->loginUser();
        $user2 = factory(User::class)->create();

        $follow = factory(Follow::class)->create([
            'send_user_id' => $user2->id,
            'receive_user_id' => $user1->id,
        ]);

        $this->get(route('activities.index'))
             ->assertOk()
             ->assertSee($user2->name)
             ->assertSee($follow->created_at->format('n月j日 H:i'))
             ;

    }

    /** @test show */
    function activitiesのshowを表示できる()
    {
        $this->seed(DatabaseSeeder::class);

        $someonesAccount = $this->notLoginUser();

        $user = $this->loginUser();

        $this->get(route('results.show', ['user' => $someonesAccount->id]))
            ->assertOk()
            ->assertSee($someonesAccount->name);
    }






    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
}
