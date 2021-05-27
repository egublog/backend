<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;


class Talk_userControllerTest extends TestCase
{

    use RefreshDatabase;

    
    /** @test index */
    function ゲストはページを表示出来ない()
    {
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();
        $this->get(route('talk_users.index'))->assertRedirect($url);
        $someonesAccount = $this->notLoginUser();
        $this->get(route('talk_users.show', ['user' => $someonesAccount->id]))->assertRedirect($url);
    }


    /** @test index */
    function talk_usersのindexを表示できる()
    {
        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();
        
        $this->get(route('talk_users.index'))
            ->assertOk()
            ->assertSee('トーク')
            ;
    }


    /** @test show */
    function talk_usersのshowを表示できる()
    {
        $this->seed(DatabaseSeeder::class);

        $someonesAccount = $this->notLoginUser();

        $user = $this->loginUser();

        $this->get(route('talk_users.show', ['user' => $someonesAccount->id]))
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
