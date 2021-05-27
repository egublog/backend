<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\Talk;



class Talk_userContentControllerTest extends TestCase
{

    use RefreshDatabase;

    
    /** @test index */
    function ゲストはページを表示出来ない()
    {
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $someonesAccount = $this->notLoginUser();
        $this->get(route('talk_users.contents.index', ['user' => $someonesAccount->id]))->assertRedirect($url);
        $this->get(route('talk_users.contents.store', ['user' => $someonesAccount->id]))->assertRedirect($url);
        $this->get(route('talk_users.contents.axios_userChange', ['user' => $someonesAccount->id]))->assertRedirect($url);
        $this->get(route('talk_users.contents.axios_talkUpdate', ['user' => $someonesAccount->id]))->assertRedirect($url);
    }


    /** @test index */
    function talk_usersContentsのindexを表示できる()
    {
        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();

        $someonesAccount = $this->notLoginUser();


        $talk1 = factory(Talk::class)->create([
            'from' => $someonesAccount->id,
            'to' => $user->id,
        ]);
        $talk2 = factory(Talk::class)->create([
            'from' => $user->id,
            'to' => $someonesAccount->id,
        ]);
        $talk3 = factory(Talk::class)->create([
            'from' => $user->id,
            'to' => $someonesAccount->id,
        ]);
        
        $this->get(route('talk_users.contents.index', ['user' => $someonesAccount->id]))
            ->assertOk()
            ->assertSee($someonesAccount->name)
            ->assertSee($talk1->talk_data)
            ->assertSee($talk2->talk_data)
            ->assertSee($talk3->talk_data)
            ;
    }

    /** @test store */
    function talk_usersContentsのstoreを実行してデータを保存できる()
    {
        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();

        $someonesAccount = $this->notLoginUser();

        $message = [
            'message' => 'こんばんみ',
            'identify_id' => 'talk_list',
        ];

        $this->post(route('talk_users.contents.store', ['user' => $someonesAccount->id]), $message)
             ->assertOk()
             ;
        
    
        $this->assertDatabaseHas('talks', [
            'from' => $user->id,
            'to' => $someonesAccount->id,
            'talk_data' => $message,
        ]);
    }


    // /** @test axiosのuserChange */
    // function talk_usersContestsのaxiosのuserChangeを実行できる()
    // {

    // }

    // /** @test axiosのtalkUpdate */
    // function talk_usersContentsのaxiosのtalkUpdateでデータを更新できる()
    // {

    // }






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
