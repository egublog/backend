<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Facades\IdentifyId;


class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();

        // でここにidentify_id と言う名前でクエリ文字列が送られてくるから
        // 　それがfollowかfollowerかで処理を分ければ良い。。
        $identify_id = $request->identify_id;

        // if ($identify_id == 'friend_follow') {
        //     // 自分がフォローしている人を取得
        //     $accounts = $myAccount->show_follow()->get();
        // } elseif ($identify_id == 'friend_follower') {
        //     // 自分をフォローしている人を取得
        //     $accounts = $myAccount->show_follower()->get();
        // }

        if (IdentifyId::friendFollow($identify_id)) {
            // 自分がフォローしている人を取得
            $accounts = $myAccount->getFollow();
        } elseif (IdentifyId::friendFollower($identify_id)) {
            // 自分をフォローしている人を取得
            $accounts = $myAccount->getFollower();
        }


        return view('myService.friend')->with([
            'accounts' => $accounts,
            // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
            'myAccount' => $myAccount,
            // ↓ ここではdetails.blade.phpへ行く時に使う、多分back用  ,,全てdetailsから帰る時に使う、
            // 、後detailsでのトークへを表示させるかどうか、←これは副次元的に、でもどこから来たか分かっていたらめっちゃ楽
            'identify_id' => $identify_id,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        $identify_id = $request->identify_id;
        $user_id = $user->id;

        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();


        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかを
        // $follow_check = $myAccount->show_follow()->where('receive_user_id', $user_id)->first();

        // $hisObject = $myAccount->firstFollowHim($user_id);

        $follow_check = $myAccount->followCheck($user_id);

        // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
        $hisAccount = User::find($user_id);


        return view('myService.details')->with([
            'identify_id' => $identify_id,
            'hisAccount' => $hisAccount,
            'follow_check' => $follow_check,
        ]);
    }
}

