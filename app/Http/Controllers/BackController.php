<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\IdentifyId;
use App\User;

class BackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fromDetails(Request $request)
    {
        // ここで受け取るidentify_idは9パターン
        $identify_id = $request->identify_id;

        // identify_idがfindかtalk_findだったら下の配列を作る
        if (IdentifyId::find($identify_id) || IdentifyId::talkFind($identify_id)) {
            $array = array(
                'user' => $request->user_id,
                'team_string' => $request->team_string,
                'era_id' => $request->era_id,
                'identify_id' => $identify_id,
                // ↑ このidentify_idは$identify_idがfindの時には要らないがまあついてても良いか
            );
        }

        if (IdentifyId::activity($identify_id)) {
            return redirect()->route('activities.index');
        } elseif (IdentifyId::friendFollow($identify_id) || IdentifyId::friendFollower($identify_id)) {
            return redirect()->route('friends.index', ['identify_id' => $identify_id]);
        } elseif (IdentifyId::find($identify_id)) {
            return redirect()->route('results.index', $array);
        } elseif (IdentifyId::talkFind($identify_id)) {
            return redirect()->route('talk_users.contents.index', $array);
        } else {
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
        // ここで受け取るidentify_idは5パターン
        $identify_id = $request->identify_id;
        $user_id = $request->user_id;

        // identify_idがfindかtalk_findだったら下の配列を作る
        if (IdentifyId::find($identify_id)) {
            $array = array(
                'user' => $request->user_id,
                'team_string' => $request->team_string,
                'era_id' => $request->era_id,
            );
        }

        if (IdentifyId::activity($identify_id)) {
            return redirect()->route('activities.show', ['user' => $user_id]);
        } elseif (IdentifyId::friendFollow($identify_id) || IdentifyId::friendFollower($identify_id)) {
            return redirect()->route('friends.show', ['user' => $user_id, 'identify_id' => $identify_id]);
        } elseif (IdentifyId::find($identify_id)) {
            return redirect()->route('results.show', $array);
        } elseif (IdentifyId::talkList($identify_id)) {
            return redirect()->route('talk_users.index');
        }
    }
}
