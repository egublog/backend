<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class Follow_detailProfile extends Controller
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
        $user_id = $request->user_id;
        $identify_id = $request->identify_id;

        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();


        // 自分がフォローしているかどうかを調べる
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $request->user_id)->first();

        // フォローしていたら外す、してなかったらフォローする
        if (isset($follow_check)) {
            $myAccount->show_follow()->detach($request->user_id);
        } else {
            $myAccount->show_follow()->attach($request->user_id);
        }

        // details.blade.phpへ帰るやつだから一覧表示じゃないからここでfollow_checkをしてあげる
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $user_id)->first();

        $hisAccount = User::find($user_id);

        // find系はera_id,team_stringをあげる
        // if ($identify_id == 'find' || $identify_id == 'talk_find') {
        if (in_array($identify_id, ['find', 'talk_find'])) {
            return view('myService.details')->with([
                'hisAccount' => $hisAccount,
                'follow_check' => $follow_check,
                'team_string' => $request->team_string,
                'era_id' => $request->era_id,
                // 'myId' => $myId,
                'identify_id' => $identify_id,
            ]);
        }

        return view('myService.details')->with([
            'hisAccount' => $hisAccount,
            'follow_check' => $follow_check,
            'identify_id' => $identify_id,
        ]);
    }
}
