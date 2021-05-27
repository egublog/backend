<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use Mockery;
use App\Facades\Profile;



class ImageControllerTest extends TestCase
{

    use RefreshDatabase;


    // /** @test update */
    // function imagesのupdateを実行してデータを更新できる()
    // {

    //     $request = null;
    //     // ここで Storageのモックを使う出番！！   (StorageではAWSのs3に保存する為)
    //     // $mock = Mockery::mock(Profile::class);

    //     // $mock->shouldReceive('saveImageToDatabaseAndReturnThePath')
    //     //      ->once()
    //     //      ->with($request)
    //     //      ->andReturn('hello');

    //     // $this->app->instance(Profile::class, $mock);

    //     $this->mock(Profile::class, function ($mock, $request) {
    //         $mock->shouldReceive('saveImageToDatabaseAndReturnThePath')
    //         ->once()
    //         ->with($request)
    //         ->andReturn('hello');
    //     });
    

    // }


    /** @test show */
    function imagesのshowを表示できる()
    {


        $this->seed(DatabaseSeeder::class);


        $user = $this->loginUser();

        $this->get(route('images.show', ['user' => $user->id]))
            ->assertOk()
            ->assertSee('プロフィールを編集');

            
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
