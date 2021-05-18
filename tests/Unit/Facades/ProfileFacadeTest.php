<?php

namespace Tests\Unit\Facades;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\All;
use App\Talk;
use App\Talk_list;
use Illuminate\Support\Collection;
use App\User;
use App\Follow;
use Illuminate\Support\Str;
use App\Facades\Profile;
use App\Team;

class ProfileFacadeTest extends TestCase
{

    use RefreshDatabase;


    /** @test returnSchoolsArrayes */
    function returnSchoolsArrayesメソッドの引数に指定したuserアカウントの配列を返す()
    {

        $this->seed(DatabaseSeeder::class);

        $user = factory(User::class)->create();

        $team1 = factory(team::class)->create();
        $team2 = factory(team::class)->create();
        $team3 = factory(team::class)->create();
        $team4 = factory(team::class)->create();

        $all1 = factory(All::class)->create([
            'user_id' => $user->id,
            'team_id' => $team1->id,
            'era_id' => 1,
        ]);
        $all2 = factory(All::class)->create([
            'user_id' => $user->id,
            'team_id' => $team2->id,
            'era_id' => 2,
        ]);
        $all3 = factory(All::class)->create([
            'user_id' => $user->id,
            'team_id' => $team3->id,
            'era_id' => 3,
        ]);
        $all4 = factory(All::class)->create([
            'user_id' => $user->id,
            'team_id' => $team4->id,
            'era_id' => 4,
        ]);

        $array = Profile::returnSchoolsArrayes($user);

        $this->assertEquals($array[0][3], $team1->team_name);
        $this->assertEquals($array[1][3], $team2->team_name);
        $this->assertEquals($array[2][3], $team3->team_name);
        $this->assertEquals($array[3][3], $team4->team_name);
        $this->assertEquals($array[0][4], $all1->position_id);
        $this->assertEquals($array[1][4], $all2->position_id);
        $this->assertEquals($array[2][4], $all3->position_id);
        $this->assertEquals($array[3][4], $all4->position_id);
    }



    // /** @test  */
    // function ()
    // {

    // }

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
