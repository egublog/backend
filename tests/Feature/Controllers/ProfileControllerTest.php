<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\All;

use function Psy\debug;

class ProfileControllerTest extends TestCase
{


    use RefreshDatabase;

    
    /** @test index */
    function ゲストはページを表示出来ない()
    {

        // $this->withoutExceptionHandling();
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $this->get(route('profiles.index'))->assertRedirect($url);
        $this->get(route('profiles.show', ['user' => $user->id]))->assertRedirect($url);

        $validData = [
            'user_name' => 'Takahashi',
            'age' => '44',
            'elementaryTeam' => '鹿島アントラーズ',
            'elementaryPosition' => '1',
            'juniorHighTeam' => '川崎フロンターレ',
            'juniorHighPosition' => '2',
            'highTeam' => '大宮アルディージャ',
            'highPosition' => '3',
            'universityTeam' => '横浜Fマリノス',
            'universityPosition' => '4',
            'introduction' => 'こんにちはよろしくお願いします',
            'area_id' => '30',
        ];
        $this->put(route('profiles.update', ['user' => $user->id]), $validData)->assertRedirect($url);

    }




    /** @test index */
    function profilesのindexを表示できる()
    {

        $this->seed(DatabaseSeeder::class);

        $this->loginUser();
        
        $this->get(route('profiles.index'))
            ->assertOk()
            ->assertSee('プロフィールを編集');
    }

    /** @test update */
    function profilesのupdateを実行してデータを更新できる()
    {

        $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);


        // $user = $this->loginUser();

        $validData = [
            'user_name' => 'Takahashi',
            'age' => '44',
            'elementaryTeam' => '鹿島アントラーズ',
            'elementaryPosition' => '1',
            'juniorHighTeam' => '川崎フロンターレ',
            'juniorHighPosition' => '2',
            'highTeam' => '大宮アルディージャ',
            'highPosition' => '3',
            'universityTeam' => '横浜Fマリノス',
            'universityPosition' => '4',
            'introduction' => 'こんにちはよろしくお願いします',
            'area_id' => '30',
        ];

        // $all = factory(All::class)->create();

        $user = $this->loginUser();

        $this->put(route('profiles.update', ['user' => $user->id]), $validData)
             ->assertOk()
             ->assertSee('プロフィールを編集');
             

             $userData = [
                'user_name' => 'Takahashi',
                'age' => '44',
                'introduction' => 'こんにちはよろしくお願いします',
                'area_id' => '30',
            ];
         $this->assertDatabaseHas('users', $userData);

        //  でチームとかも登録出来ているかをリレーションで確認する。

        $this->assertEquals('Takahashi', $user->fresh()->user_name);
        $this->assertEquals('44', $user->fresh()->age);
        $this->assertEquals('鹿島アントラーズ', $user->fresh()->returnTeamName(1));
        $this->assertEquals('1', $user->fresh()->returnPositionId(1));
        $this->assertEquals('川崎フロンターレ', $user->fresh()->returnTeamName(2));
        $this->assertEquals('2', $user->fresh()->returnPositionId(2));
        $this->assertEquals('大宮アルディージャ', $user->fresh()->returnTeamName(3));
        $this->assertEquals('3', $user->fresh()->returnPositionId(3));
        $this->assertEquals('横浜Fマリノス', $user->fresh()->returnTeamName(4));
        $this->assertEquals('4', $user->fresh()->returnPositionId(4));
        $this->assertEquals('こんにちはよろしくお願いします', $user->fresh()->introduction);
        $this->assertEquals('30', $user->fresh()->area_id);

    }

    /** @test show */
    function profilesのshowを表示できる()
    {

        $this->seed(DatabaseSeeder::class);


        $user = $this->loginUser();

        $this->get(route('profiles.show', ['user' => $user->id]))
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
