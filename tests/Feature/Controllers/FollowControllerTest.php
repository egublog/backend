<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;


class FollowControllerTest extends TestCase
{

    
    /** @test index */
    function ゲストはページを表示出来ない()
    {
        
    }

    
    /** @test store */
    function followsのstoreを実行したらフォローテーブルにデータを保存できる()
    {

    }


    /** @test destroy */
    function followsのdestroyを実行したらフォローテーブルからデータを削除できる()
    {

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
