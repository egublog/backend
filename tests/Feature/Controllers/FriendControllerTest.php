<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// use App\User;
use DatabaseSeeder;
// use App\All;


class FriendControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test index */
    function ゲストはfriendsのページを表示出来ない()
    {
        // $this->withoutExceptionHandling();


        
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $this->get(route('friends.index'))->assertRedirect($url);
        $this->get(route('friends.show', ['user' => $user->id]))->assertRedirect($url);
    }




    /** @test index */
    function friendsのindexのページを表示できる()
    {

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();
        
        $this->get(route('friends.index', ['identify_id' => 'friend_follow']))
            ->assertOk()
            ->assertSee('フォロー');
        $this->get(route('friends.index', ['identify_id' => 'friend_follower']))
             ->assertOk()
             ->assertSee('フォローワー');

    }
    
    /** @test show */
    function friendsのshowのページを表示できる()
    {

        $this->withoutExceptionHandling();

        
        $this->seed(DatabaseSeeder::class);

        $someonesAccount = $this->notLoginUser();

        $user = $this->loginUser();

        $this->get(route('friends.show', ['user' => $someonesAccount->id]))
             ->assertOk()
             ->assertSee($someonesAccount->name);


        // フォローしていたら『メッセージ』ボタンが見える  ⇦これは非同期処理の専門分野でテストするべし！！
        // $this->followSomeonesAccount($someonesAccount);
        // $this->post(route('follows.store'), ['user_id' => $someonesAccount->id]);

        // $this->get(route('friends.show', ['user' => $someonesAccount->id]))
        //     ->assertOk()
        //     ->assertDontSee('メッセージ');


        // フォローしていなかったら『メッセージ』ボタンが見えない

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
