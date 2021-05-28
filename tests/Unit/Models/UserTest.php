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
use App\Follow;
use Illuminate\Support\Str;


class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test alls */
    function allsリレーションを返す()
    {

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();

        $user = factory(User::class)->create();
        factory(All::class)->create([
            'user_id' => $user->id,
        ]);

        
        $this->assertInstanceOf(All::class, $user->alls()->first());
        
    }

    /** @test follows */
    function followsリレーションを返す()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->follows);
    }
    
    
    /** @test talks */
    function talksリレーションを返す()
    {
        $this->seed(DatabaseSeeder::class);
    
        $user = factory(User::class)->create();


        $this->assertInstanceOf(Collection::class, $user->talks);

    }

    /** @test talks_lists */
    function talks_listsリレーションを返す()
    {
        $this->seed(DatabaseSeeder::class);
    
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->talk_lists);
        

    }

    /** @test show_follow */
    function show_followリレーションを返す()
    {
        $this->seed(DatabaseSeeder::class);
    
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->show_follow);


    }

    /** @test show_follower */
    function show_followerリレーションを返す()
    {
        $this->seed(DatabaseSeeder::class);
    
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->show_follower);


    }
    /** @test show_follower_activity */
    function show_follower_activityリレーションを返す()
    {
        $this->seed(DatabaseSeeder::class);
    
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->show_follower_activity);


    }






    /** @test changeAreaIdToPrefecturesName */
    function changeAreaIdToPrefecturesNameメソッドで引数にarea_idを入れたら対応する都道府県名が返ってくる()
    {
        $user = factory(User::class)->create([
            'area_id' => 47,
        ]);

        $this->assertEquals($user->changeAreaIdToPrefecturesName($user->area_id), '沖縄県');

    }





    /** @test returnTeamName */
    function returnTeamNameメソッドでteam_nameが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user = factory(User::class)->create();
        factory(All::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->returnTeamName(1), '未設定です。');

    }



    /** @test returnPositionId */
    function returnPositionIdメソッドでposition_idが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user = factory(User::class)->create();
        factory(All::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->returnPositionId(1), 1);


    }
    /** @test getFollow */
    function getFollowメソッドで自分がフォローしているユーザーコレクションが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        factory(Follow::class)->create([
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);
        
        // $user1FollowCollection = $user1->getFollow();

        $this->assertEquals($user1->getFollow()->first()->id, $user2->id);

    }
    /** @test getFollower */
    function getFollowerメソッドで自分をフォローしているユーザーコレクションが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        factory(Follow::class)->create([
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);
        
        // $user1FollowCollection = $user1->getFollower();

        $this->assertEquals($user2->getFollower()->first()->id, $user1->id);

    }
    /** @test getFollowerActivity */
    function getFollowerActivityメソッドで自分をフォローしているユーザーコレクションが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        factory(Follow::class)->create([
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);
        
        // $user1FollowCollection = $user1->getFollower();

        $this->assertEquals($user2->getFollower()->first()->id, $user1->id);

    }

    /** @test firstFollowHim */
    function firstFollowHimメソッドで自分がその人をフォローしていたらその人のインスタンスが返って来て、フォローしていなかったらnullが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();


        factory(Follow::class)->create([
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);

        $this->assertEquals($user1->firstFollowHim($user2->id)->id, User::where('id', $user2->id)->first()->id);

        $this->assertNull($user1->firstFollowHim($user3->id));
    }


    /** @test followCheck */
    function followCheckメソッドで引数に指定したidのuserをフォローしていたらtrue、していなかったらfalseが返ってくる()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();


        factory(Follow::class)->create([
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);

        $this->assertTrue($user1->followCheck($user2->id));
        $this->assertFalse($user1->followCheck($user3->id));

    }




    /** @test followAttach */
    function followAttachメソッドで引数に指定したidと自分のidをfollowsテーブルに保存する()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $user1->followAttach($user2->id);

        $this->assertDatabaseHas('follows', [
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);

    }
    /** @test followDetach */
    function followDetachメソッドで引数に指定したidと自分のidをfollowsテーブルから削除する()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        factory(Follow::class)->create([
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);

        $this->assertDatabaseHas('follows', [
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);
        
        $user1->followDetach($user2->id);
        
        $this->assertDatabaseMissing('follows', [
            'send_user_id' => $user1->id,
            'receive_user_id' => $user2->id,
        ]);
        

    }
    /** @test saveColumn */
    function saveColumnメソッドで第一引数に指定したインスタンスから第二引数に指定したカラム名のデータをこのインスタンスのテーブルへと保存する()
    {
        $this->seed(DatabaseSeeder::class);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->make([
            'user_name' => 'Yamada',
            'age' => 22,
            'introduction' => 'こんばんみ',
            'area_id' => 44,
        ]);

        $this->assertDatabaseMissing('users', [
            'user_name' => 'Yamada',
            'age' => 22,
            'introduction' => 'こんばんみ',
            'area_id' => 44,
        ]);


        $user1->saveColumn($user2, 'user_name');
        $user1->saveColumn($user2, 'age');
        $user1->saveColumn($user2, 'introduction');
        $user1->saveColumn($user2, 'area_id');

        $this->assertDatabaseHas('users', [
            'user_name' => 'Yamada',
            'age' => 22,
            'introduction' => 'こんばんみ',
            'area_id' => 44,
        ]);

        
        



    }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

    // }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

    // }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

    // }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

    // }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

    // }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

    // }
    // /** @test  */
    // function ()
    // {
    //     $this->seed(DatabaseSeeder::class);

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
