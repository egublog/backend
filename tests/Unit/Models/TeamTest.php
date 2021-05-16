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

class TeamTest extends TestCase
{

    use RefreshDatabase;


     /** @test team */
     function teamリレーションを返す()
     {
 
         // $this->withoutExceptionHadling();
 
         $this->seed(DatabaseSeeder::class);
     
         $team = factory(Team::class)->create();
         // $user = $this->loginUser();
         factory(All::class)->create([
             'team_id' => $team->id,
         ]);


         $this->assertInstanceOf(All::class, $team->alls()->first());
 
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
