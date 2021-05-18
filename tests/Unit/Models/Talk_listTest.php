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


    /** @test scopeOurTalkList */
    function scopeOurTalkListスコープで自分と相手のtalkListテーブルに入っているデータに絞る()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $user4 = factory(User::class)->create();

        $talk_list1 = factory(Talk_list::class)->create([
            'from' => $user1->id,
            'to' => $user2->id,
        ]);
        $talk_list2 = factory(Talk_list::class)->create([
            'from' => $user1->id,
            'to' => $user3->id,
        ]);
        $talk_list3 = factory(Talk_list::class)->create([
            'from' => $user2->id,
            'to' => $user3->id,
        ]);
        $talk_list4 = factory(Talk_list::class)->create([
            'from' => $user2->id,
            'to' => $user4->id,
        ]);
        $talk_list5 = factory(Talk_list::class)->create([
            'from' => $user3->id,
            'to' => $user4->id,
        ]);

        $talk_list = Talk_list::ourTalkList($user1->id, $user2->id)->get();

        $this->assertTrue($talk_list->contains($talk_list1));
        $this->assertFalse($talk_list->contains($talk_list2));
        $this->assertFalse($talk_list->contains($talk_list3));
        $this->assertFalse($talk_list->contains($talk_list4));
        $this->assertFalse($talk_list->contains($talk_list5));
    }



    /** @test saveNewTalkList */
    function saveNewTalkListメソッドで引数に渡したトークデータをtalkテーブルに保存する()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $new_talk_list = new Talk_list();
        $new_talk_list->saveNewTalkList($user1->id, $user2->id);

        $this->assertDatabaseHas('talk_lists', [
            'from' => $user1->id,
            'to' => $user2->id,
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
