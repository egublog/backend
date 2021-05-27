<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;


class AxiosControllerTest extends TestCase
{

    use RefreshDatabase;


    /** @test index */
    function ゲストはページを表示出来ない()
    {
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $this->post(route('axios.logout'))->assertRedirect($url);
    }

    /** @test axios logout */
    function axiosのlogoutを実行したらログアウト出来てログインページにリダイレクトできる()
    {
        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();

        $this->post(route('axios.logout'))
            ->assertStatus(200);


        // ユーザーが認証されていないことを確認
        $this->assertGuest();
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
