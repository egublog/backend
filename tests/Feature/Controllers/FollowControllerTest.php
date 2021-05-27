<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\Follow;


class FollowControllerTest extends TestCase
{

    use RefreshDatabase;


    
    /** @test index */
    function ゲストはページを表示出来ない()
    {
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $someonesAccount = $this->notLoginUser();

        $this->post(route('follows.store'), ['user' => $someonesAccount->id])->assertRedirect($url);
        $this->delete(route('follows.destroy', ['user' => $someonesAccount->id]))->assertRedirect($url);

    }

    
    /** @test store */
    function followsのstoreを実行したらフォローテーブルにデータを保存できる()
    {
        $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();

        $someonesAccount = $this->notLoginUser();

        $this->post(route('follows.store', ['user_id' => $someonesAccount->id]))
             ->assertOk()
             ;
        
        $this->assertDatabaseHas('follows', [
            'send_user_id' => $user->id,
            'receive_user_id' => $someonesAccount->id,
        ]);

    }


    /** @test destroy */
    function followsのdestroyを実行したらフォローテーブルからデータを削除できる()
    {

        $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();

        $someonesAccount = $this->notLoginUser();
        $user2 = $this->notLoginUser();


        $follow1 = factory(Follow::class)->create([
            'send_user_id' => $user->id,
            'receive_user_id' => $someonesAccount->id,
        ]);
        $follow2 = factory(Follow::class)->create([
            'send_user_id' => $user->id,
            'receive_user_id' => $user2->id,
        ]);
        
        
        $this->assertDatabaseHas('follows', [
            'send_user_id' => $user->id,
            'receive_user_id' => $someonesAccount->id,
        ]);
        $this->assertDatabaseHas('follows', [
            'send_user_id' => $user->id,
            'receive_user_id' => $user2->id,
        ]);
        
        $this->delete(route('follows.destroy', ['user' => $someonesAccount->id]))
        ->assertOk()
        ;
        
        $this->assertDatabaseMissing('follows', [
            'send_user_id' => $user->id,
            'receive_user_id' => $someonesAccount->id,
        ]);
        $this->assertDatabaseHas('follows', [
            'send_user_id' => $user->id,
            'receive_user_id' => $user2->id,
        ]);
        



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
