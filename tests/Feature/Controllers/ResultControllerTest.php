<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\Team;
use App\All;


class ResultControllerTest extends TestCase
{


    /** @test index */
    function ゲストはページを表示出来ない()
    {

        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $validData = [
            'era_id' => 1,
            'team_string' => '鹿島アントラーズ',
        ];

        $this->get(route('results.index', $validData))->assertRedirect($url);

        // $this->get(route('results.show', $validData))->assertRedirect($url);
        $someonesAccount = $this->notLoginUser();

        $this->get(route('results.show', ['user' => $someonesAccount->id]))->assertRedirect($url);
    }


    /** @test index */
    function resultsのindexを表示できる()
    {

        $this->seed(DatabaseSeeder::class);

        $user1 = $this->loginUser();
        $user2 = $this->loginUser();

        $team1 = factory(team::class)->create(['team_name' => '鹿島アントラーズ']);
        $team2 = factory(team::class)->create();
        $team3 = factory(team::class)->create();
        $team4 = factory(team::class)->create();

        $all1 = factory(All::class)->create([
            'user_id' => $user1->id,
            'position_id' => 1,
            'team_id' => $team1->id,
            'era_id' => 1,
        ]);
        $all2 = factory(All::class)->make([
            'user_id' => $user1->id,
            'position_id' => 2,
            'team_id' => $team2->id,
            'era_id' => 1,
        ]);
        $all3 = factory(All::class)->create([
            'user_id' => $user2->id,
            'position_id' => 1,
            'team_id' => $team1->id,
            'era_id' => 2,
        ]);
        $all4 = factory(All::class)->make([
            'user_id' => $user2->id,
            'position_id' => 2,
            'team_id' => $team2->id,
            'era_id' => 2,
        ]);




        $validData = [
            'era_id' => '1',
            'team_string' => '鹿島アントラーズ',
        ];


        $this->get(route('results.index', $validData))
            ->assertOk()
            ->assertSee('年代')
            ->assertSee('所属チーム')
            ->assertSee('鹿島アントラーズ')
            ->assertSee($user1->name);
    }

    /** @test show */
    function resultsのshowを表示できる()
    {
        $this->seed(DatabaseSeeder::class);

        $someonesAccount = $this->notLoginUser();

        $user = $this->loginUser();

        $this->get(route('results.show', ['user' => $someonesAccount->id]))
            ->assertOk()
            ->assertSee($someonesAccount->name);
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
