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
use App\Facades\IdentifyId;

class IdentifyIdFacadeTest extends TestCase
{


    /** @test friendFollow */
    function friendFollowメソッドで引数がfriend_followだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::friendFollow('friend_follow'));
         $this->assertFalse(IdentifyId::friendFollow('hoge'));
    }

    /** @test friendFollower */
    function friendFollowerメソッドで引数がfriend_followerだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::friendFollower('friend_follower'));
         $this->assertFalse(IdentifyId::friendFollower('hoge'));
    }


    /** @test activity */
    function activityメソッドで引数がactivityだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::activity('activity'));
         $this->assertFalse(IdentifyId::activity('hoge'));
    }


    /** @test find */
    function findメソッドで引数がfindだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::find('find'));
         $this->assertFalse(IdentifyId::find('hoge'));
    }


    /** @test talkList */
    function talkListメソッドで引数がtalk_listだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::talkList('talk_list'));
         $this->assertFalse(IdentifyId::talkList('hoge'));
    }


    /** @test talkFriendFollow */
    function talkFriendFollowメソッドで引数がtalk_friend_followだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::talkFriendFollow('talk_friend_follow'));
         $this->assertFalse(IdentifyId::talkFriendFollow('hoge'));
    }


    /** @test talkFriendFollower */
    function talkFriendFollowerメソッドで引数がtalk_friend_followerだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::talkFriendFollower('talk_friend_follower'));
         $this->assertFalse(IdentifyId::talkFriendFollower('hoge'));
    }


    /** @test talkActivity */
    function talkActivityメソッドで引数がtalk_activityだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::talkActivity('talk_activity'));
         $this->assertFalse(IdentifyId::talkActivity('hoge'));
    }


    /** @test talkFind */
    function talkFindメソッドで引数がtalk_findだったらtrueそれ以外がfalse()
    {
         $this->assertTrue(IdentifyId::talkFind('talk_find'));
         $this->assertFalse(IdentifyId::talkFind('hoge'));
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
