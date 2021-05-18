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

class TalkTest extends TestCase
{

    use RefreshDatabase;



    /** @test user */
    function userリレーションを返す()
    {

        // $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);

        $talk = factory(Talk::class)->create();
        // $user = $this->loginUser();

        $this->assertInstanceOf(User::class, $talk->user);
    }


    /** @test scopeYetColumnsFalse */
    function scopeYetColumnsFalseスコープで引数に指定した相手から自分に送られたトークデータでyetカラムがfalseのものを取得()
    {

        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $talk1 = factory(Talk::class)->create([
            'from' => $user2->id,
            'to' => $user1->id,
        ]);
        $talk2 = factory(Talk::class)->create([
            'from' => $user1->id,
            'to' => $user2->id,
            'yet' => true,
        ]);
        $talk3 = factory(Talk::class)->create([
            'from' => $user3->id,
            'to' => $user1->id,
        ]);


        $talkDatas = Talk::yetColumnsFalse($user1->id, $user2->id)->get();

        $this->assertTrue($talkDatas->contains($talk1));
        $this->assertFalse($talkDatas->contains($talk2));
        $this->assertFalse($talkDatas->contains($talk3));
    }


    /** @test scopeTalkDatasLatestLimit */
    function scopeTalkDatasLatestLimitで引数に指定した相手と自分のトークデータを新しい順に引数に指定した数だけを取得()
    {

        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $talks1 = factory(Talk::class, 5)->create([
            'from' => $user2->id,
            'to' => $user1->id,
        ]);
        $talks3 = factory(Talk::class, 5)->create([
            'from' => $user3->id,
            'to' => $user1->id,
        ]);
        $talks2 = factory(Talk::class, 5)->create([
            'from' => $user1->id,
            'to' => $user2->id,
            'yet' => true,
        ]);

        $talkDatasDesc = Talk::TalkDatasLatestLimit($user1->id, $user2->id, 6)->with('user')->get();


        // dd($talks1);
        foreach ($talks1 as $talk1) {
            $this->assertTrue($talkDatasDesc->contains($talk1));
        }

        foreach ($talks3 as $talk3) {
            $this->assertFalse($talkDatasDesc->contains($talk3));
        }

        $this->assertTrue($talkDatasDesc->contains($talks2[0]));
        $this->assertFalse($talkDatasDesc->contains($talks2[1]));
        $this->assertFalse($talkDatasDesc->contains($talks2[2]));
        $this->assertFalse($talkDatasDesc->contains($talks2[3]));
        $this->assertFalse($talkDatasDesc->contains($talks2[4]));
    }

    /** @test scopeTalkDataOneBefore */
    function scopeTalkDataOneBeforeメソッドで自分と相手のトークデータの最新のから一つ手前のトークデータを取得する()
    {

        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $talk1 = factory(Talk::class)->create([
            'from' => $user2->id,
            'to' => $user1->id,
        ]);
        $talk2 = factory(Talk::class)->create([
            'from' => $user1->id,
            'to' => $user2->id,
        ]);
        $talk3 = factory(Talk::class)->create([
            'from' => $user1->id,
            'to' => $user2->id,
        ]);

        $talkDataOneBefore = Talk::TalkDataOneBefore($user1->id, $user2->id)->get();


        $this->assertTrue($talkDataOneBefore->contains($talk2));
        $this->assertFalse($talkDataOneBefore->contains($talk1));
        $this->assertFalse($talkDataOneBefore->contains($talk3));
    }

    /** @test scopeTalkDataNow */
    function scopeTalkDataNowメソッドで自分と相手のトークデータを新しい順に取得する()
    {

        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $talk1 = factory(Talk::class)->create([
            'from' => $user2->id,
            'to' => $user1->id,
            'created_at' => 1,
        ]);
        $talk2 = factory(Talk::class)->create([
            'from' => $user1->id,
            'to' => $user2->id,
            'created_at' => 2,
        ]);
        $talk3 = factory(Talk::class)->create([
            'from' => $user1->id,
            'to' => $user2->id,
            'created_at' => 3,
        ]);

        $talkDataNow = Talk::TalkDataNow($user1->id, $user2->id)->get();

        // dd($talkDataNow, $talk3->id);
        $this->assertEquals($talkDataNow[0]->id, $talk3->id);
        $this->assertEquals($talkDataNow[1]->id, $talk2->id);
        $this->assertEquals($talkDataNow[2]->id, $talk1->id);
    }



    /** @test saveNewTalk */
    function saveNewTalkメソッドで引数に渡したトークデータをtalkテーブルに保存する()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $message = 'こんばんみ';

        $talkData = new Talk();
        $talkData->saveNewTalk($message, $user1->id, $user2->id);
    
        $this->assertDatabaseHas('talks', [
            'from' => $user1->id,
            'to' => $user2->id,
            'talk_data' => $message,
        ]);

    }


    // /** @test saveTalkCheckColumn */
    // function saveTalkCheckColumnでtalksテーブルのtalkCheckカラムをその日初めてのトークだったらtrueにする()
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
