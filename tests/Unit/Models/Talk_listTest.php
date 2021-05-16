<?php

namespace Tests\Unit\Models;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\All;
use App\Talk;
use App\Talk_list;
use Illuminate\Support\Collection;
use App\User;
use App\Team;

class Talk_listTest extends TestCase
{



    use RefreshDatabase;


    /** @test user */
    function userリレーションを返す()
    {

        // $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);
    
        $talk_list = factory(Talk_list::class)->create();
        // $user = $this->loginUser();

        $this->assertInstanceOf(User::class, $talk_list->user);
        

    }


    // /**
    //  * A basic unit test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }
}
