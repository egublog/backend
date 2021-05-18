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


     /** @test scopeTeamNameEqual */
    function scopeTeamNameEqualスコープで引数のチーム名のデータを取れる()
    {
        $this->seed(DatabaseSeeder::class);

        $team1 = factory(team::class)->create();
        $team2 = factory(team::class)->create();
        $team3 = factory(team::class)->create();
        $team4 = factory(team::class)->create();

        $teamCollection = Team::teamNameEqual($team1->team_name)->get();

        $this->assertTrue($teamCollection->contains($team1));
        $this->assertFalse($teamCollection->contains($team2));
        $this->assertFalse($teamCollection->contains($team3));
        $this->assertFalse($teamCollection->contains($team4));
    }

    /** @test saveTeam */
    function saveTeamメソッドで引数に渡したトークデータをtalkテーブルに保存する()
    {
        $this->seed(DatabaseSeeder::class);
        
        $team = factory(team::class)->make();
        

        $new_talk_list = new Team();
        $new_talk_list->saveTeam($team->team_name);

        $this->assertDatabaseHas('teams', [
            'team_name' => $team->team_name,
        ]);
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
