<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fromDetails(Request $request)
    {
        //
        // ここで$requestから受け取る値は
        //  identify_id、　find系列は$team_stringと$era_id  talk_〇〇は$userのidを添えて

        // 行う処理は
        // identify_idがtalk_〇〇だったらtalk_users.contents.indexにリダイレクト
        // $identify_idと(talk_findの時は$team_stringと$era_idと)$userのidのパラメータを添えて。

        // identify_idがfriend_followかfriend_followerだったらfriends.indexにリダイレクト
        // $identify_idを添えて

        // identify_idがactivityだったらactivities.indexにリダイレクト

        // identify_idがfindだったらresults.indexにリダイレクト
        // $era_idと$team_stringを添えて



        $identify_id = $request->identify_id;

        // if($identify_id == 'find' || $identify_id == 'talk_find') {
        if (in_array($identify_id, ['find', 'talk_find'])) {
            $array = array(
                'user' => $request->user_id,
                'team_string' => $request->team_string,
                'era_id' => $request->era_id,
            );
        }

        if($identify_id == 'activity') {
            return redirect()->route('activities.index');
        // } elseif($identify_id == 'friend_follow' || $identify_id == 'friend_follower') {

        } elseif(in_array($identify_id, ['friend_follow', 'friend_follower'])) {
            return redirect()->route('friends.index', ['identify_id' => $identify_id ]);

        } elseif($identify_id == 'find') {
            return redirect()->route('results.index', $array);
            
        } elseif($identify_id == 'talk_find') {
            return redirect()->route('talk_users.contents.index', $array);
        // } elseif($identify_id == 'talk_activity' || $identify_id == 'talk_friend_follow' || $identify_id == 'talk_friend_follower' || $identify_id == 'talk_list') {
        } elseif(in_array($identify_id, ['talk_activity', 'talk_friend_follow', 'talk_friend_follower', 'talk_list'])) {
            return redirect()->route('talk_users.contents.index', ['user' => $request->user_id, 'identify_id' => $identify_id]);
        }


    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fromTalk_show(Request $request)
    {
        //
         // ここで$requestから受け取る値は
        //  identify_id、$userのid　find系列は$team_stringと$era_id  
        // ただしidentify_idがtalk_listの時は何も要らない

        // identify_idがtalk_listだったら裸でtalk_users.indexへリダイレクト

        // identify_idがfindだったら
        // $userのid $team_string, $era_idを付けてresults.showへリダイレクト

        // identify_idがactivityだったら
        // userのidを付けてactivities.showへリダイレクト
        
        // identify_idがfriend_follow, friend_followerだったら
        // $userのid, $identify_idを付けてfriends.showへ
        
        $identify_id = $request->identify_id;
        $user_id = $request->user_id;


        if($identify_id == 'find') {
            $array = array(
                'user' => $request->user_id,
                'team_string' => $request->team_string,
                'era_id' => $request->era_id,
            );
        }

        if($identify_id == 'activity') {
            return redirect()->route('activities.show', ['user' => $user_id]);
        // } elseif($identify_id == 'friend_follow' || $identify_id == 'friend_follower') {
        } elseif(in_array($identify_id, ['friend_follow', 'friend_follower'])) {
            return redirect()->route('friends.show', ['user' => $user_id, 'identify_id' => $identify_id ]);
        } elseif($identify_id == 'find') {
            return redirect()->route('results.show', $array);
        } elseif($identify_id == 'talk_list') {
            return redirect()->route('talk_users.index');
        }



    }
   
    
}
