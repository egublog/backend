<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class Follow_listProfile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();


        // その人を自分がフォローしているかどうかを調べる
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $request->user_id)->first();

        // フォローしていたら外す、してなかったらフォローする
        if (isset($follow_check)) {
            $myAccount->show_follow()->detach($request->user_id);
        } else {
            $myAccount->show_follow()->attach($request->user_id);
        }

        $identify_id = $request->identify_id;

        // identify_idがfindの場合はこれが必要 他はなんもいらない(一覧表示で$変数が必要なのはfind_returnから来たやつだけ)
        if ($identify_id == 'find') {
            $array = array(
                // 'user' => $request->user_id,
                'era_id' => $request->era_id,
                'team_string' => $request->team_string,
                'identify_id' => $identify_id,
            );
        }
    

        // if ($identify_id == 'friend_follow' || $identify_id == 'friend_follower') {
        if (in_array($identify_id, ['friend_follow', 'friend_follower'])) {
            return redirect()->route('friends.index', ['identify_id' => $identify_id ]);
        } elseif ($identify_id == 'activity') {
            return redirect()->route('activities.index');
        } elseif ($identify_id == 'find') {
            return redirect()->route('results.index', $array);
        }
    }
}
