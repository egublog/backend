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

class AllTest extends TestCase
{


    use RefreshDatabase;


    /** @test team */
    function teamリレーションを返す()
    {

        // $this->withoutExceptionHadling();

        $this->seed(DatabaseSeeder::class);
    
        $all = factory(All::class)->create();
        // $user = $this->loginUser();

        $this->assertInstanceOf(Team::class, $all->team);

    }
    
    /** @test user */
    function userリレーションを返す()
    {

        // $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);
    
        $all = factory(All::class)->create();
        // $user = $this->loginUser();

        $this->assertInstanceOf(User::class, $all->user);

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
