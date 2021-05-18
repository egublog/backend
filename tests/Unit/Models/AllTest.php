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


    /** @test changeEraIdToEraName */
    function changeEraIdToEraNameメソッドで引数にera_idを入れたら対応する学校名が返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $all = factory(All::class)->create([
            'era_id' => 2,
        ]);

        $this->assertEquals($all->changeEraIdToEraName($all->era_id), '中学校');
    }

    /** @test changePositionIdToPositionName */
    function changePositionIdToPositionNameメソッドで引数にposition_idを入れたら対応するポジション名が返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $all = factory(All::class)->create([
            'position_id' => 3,
        ]);

        $this->assertEquals($all->changePositionIdToPositionName($all->position_id), 'MF');
    }


    /** @test getSearchAll */
    function getSearchAllメソッドで引数に指定したera_idとteam_idに一致したコレクションを返す()
    {

        $this->seed(DatabaseSeeder::class);

        $user = factory(User::class)->create();

        $all1 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 1,
        ]);
        $all2 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 2,
        ]);
        $all3 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 3,
        ]);
     

        $alls = All::getSearchAll(1, 1);

        $this->assertTrue($alls->contains($all1));
        $this->assertFalse($alls->contains($all2));
        $this->assertFalse($alls->contains($all3));

    }



    /** @test scopeMyIdEraEqual */
    function myIdEraEqualスコープで引数に指定したuser_idとera_idに一致するコレクションを返す()
    {
        $this->seed(DatabaseSeeder::class);

        $user = factory(User::class)->create();

        $all1 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 1,
        ]);
        $all2 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 2,
        ]);
        $all3 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 3,
        ]);
     

        $alls = All::myIdEraEqual($user->id, 1)->get();

        $this->assertTrue($alls->contains($all1));
        $this->assertFalse($alls->contains($all2));
        $this->assertFalse($alls->contains($all3));

    }




    /** @test saveTeamIdAndPositionId */
    function saveTeamIdAndPositionIdで引数に指定したteam_idとposition_idの値をこのインスタンスに保存する()
    {

        $this->seed(DatabaseSeeder::class);

        $user = factory(User::class)->create();

        $all1 = factory(All::class)->create([
            'user_id' => $user->id,
            'position_id' => 1,
            'team_id' => 1,
            'era_id' => 1,
        ]);
        $all2 = factory(All::class)->make([
            'user_id' => $user->id,
            'position_id' => 2,
            'team_id' => 2,
            'era_id' => 1,
        ]);

        $this->assertDatabaseMissing('alls', [
            'user_id' => $user->id,
            'position_id' => 2,
            'team_id' => 2,
            'era_id' => 1,
        ]);


        $all1->saveTeamIdAndPositionId($all2->team_id, $all2->position_id);
        

     

        $this->assertDatabaseHas('alls', [
            'user_id' => $user->id,
            'position_id' => 2,
            'team_id' => 2,
            'era_id' => 1,
        ]);


        $this->assertEquals(2, $all1->fresh()->position_id);
        $this->assertEquals(2, $all1->fresh()->team_id);



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
