<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;


class BackControllerTest extends TestCase
{

    use RefreshDatabase;

    
    /** @test index */
    function ゲストはページを表示出来ない()
    {
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $this->get(route('backs.from_details'))->assertRedirect($url);
        $this->get(route('backs.from_talk_show'))->assertRedirect($url);
    }

    /** @test backFrom_details */
    function backのfrom_detailsを実行したら来たところに戻れる()
    {

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();


        $array = array(
            'user_id' => $user->id,
            'team_string' => '鹿島アントラーズ',
            'era_id' => '1',
        );
        $array_redirect = array(
            'user' => $user->id,
            'team_string' => '鹿島アントラーズ',
            'era_id' => '1',
        );

        $array['identify_id'] = 'find';
        $array_redirect['identify_id'] = 'find';
        
        $this->get(route('backs.from_details', $array))
             ->assertRedirect(route('results.index', $array_redirect))
        ;
        
        $array['identify_id'] = 'talk_find';
        $array_redirect['identify_id'] = 'talk_find';

        $this->get(route('backs.from_details', $array))
             ->assertRedirect(route('talk_users.contents.index', $array_redirect))
        ;

        $identify_id = 'activity';
        $this->get(route('backs.from_details', ['identify_id' => $identify_id]))
             ->assertRedirect(route('activities.index'))
        ;
        $identify_id = 'friend_follow';
        $this->get(route('backs.from_details', ['identify_id' => $identify_id]))
             ->assertRedirect(route('friends.index', ['identify_id' => $identify_id]))
        ;
        $identify_id = 'friend_follower';
        $this->get(route('backs.from_details', ['identify_id' => $identify_id]))
             ->assertRedirect(route('friends.index', ['identify_id' => $identify_id]))
        ;
        
        $talk_array = [
            'user_id' => $user->id,
        ];
        
        $talk_array_redirect = [
            'user' => $user->id,
        ];
        

        $talk_array['identify_id'] = 'talk_list';
        $talk_array_redirect['identify_id'] = 'talk_list';

        $this->get(route('backs.from_details', $talk_array))
             ->assertRedirect(route('talk_users.contents.index', $talk_array_redirect))
        ;

        $talk_array['identify_id'] = 'talk_activity';
        $talk_array_redirect['identify_id'] = 'talk_activity';

        $this->get(route('backs.from_details', $talk_array))
             ->assertRedirect(route('talk_users.contents.index', $talk_array_redirect))
        ;

        $talk_array['identify_id'] = 'talk_friend_follow';
        $talk_array_redirect['identify_id'] = 'talk_friend_follow';

        $this->get(route('backs.from_details', $talk_array))
             ->assertRedirect(route('talk_users.contents.index', $talk_array_redirect))
        ;

        $talk_array['identify_id'] = 'talk_friend_follower';
        $talk_array_redirect['identify_id'] = 'talk_friend_follower';

        $this->get(route('backs.from_details', $talk_array))
             ->assertRedirect(route('talk_users.contents.index', $talk_array_redirect))
        ;


    }

    /** @test backFrom_talk_show */
    function backのfrom_talk_showを実行したら来たところに戻れる()
    {

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();


        $array = array(
            'user_id' => $user->id,
            'team_string' => '鹿島アントラーズ',
            'era_id' => '1',
            'identify_id' => 'find'
        );
        $array_redirect = array(
            'user' => $user->id,
            'team_string' => '鹿島アントラーズ',
            'era_id' => '1',
        );

        $this->get(route('backs.from_talk_show', $array))
             ->assertRedirect(route('results.show', $array_redirect))
        ;


        $talk_array = [
            'user_id' => $user->id,
        ];
        $talk_array_redirect = [
            'user' => $user->id,
        ];
        $talk_array['identify_id'] = 'activity';
        
        $this->get(route('backs.from_talk_show', $talk_array))
        ->assertRedirect(route('activities.show', $talk_array_redirect))
        ;

        $talk_array = [
            'user_id' => $user->id,
        ];
        $talk_array_redirect = [
            'user' => $user->id,
        ];
        $talk_array['identify_id'] = 'talk_list';
        
        $this->get(route('backs.from_talk_show', $talk_array))
        ->assertRedirect(route('talk_users.index'))
        ;
        
        $talk_array['identify_id'] = 'friend_follow';
        $talk_array_redirect['identify_id'] = 'friend_follow';
        $this->get(route('backs.from_talk_show', $talk_array))
        ->assertRedirect(route('friends.show', $talk_array_redirect))
        ;
        
        
        $talk_array['identify_id'] = 'friend_follower';
        $talk_array_redirect['identify_id'] = 'friend_follower';
        $this->get(route('backs.from_talk_show', $talk_array))
        ->assertRedirect(route('friends.show', $talk_array_redirect))
        ;
        


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
