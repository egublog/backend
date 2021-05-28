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
        $myAccount = Auth::user();

        // でここにidentify_id と言う名前でクエリ文字列が送られてくるから
        //  それがfollowかfollowerかで処理を分ければ良い。。
        $identify_id = $request->identify_id;


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
            // 、あとdetailsでのトークへを表示させるかどうか、←これは副次元的に、でもどこから来たか分かっていたらめっちゃ楽
            'identify_id' => $request->identify_id,
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
        $user_id = $user->id;
        $myAccount = Auth::user();
        $follow_check = $myAccount->followCheck($user_id);

        return view('myService.details')->with([
            'identify_id' => $request->identify_id,
            'hisAccount' => User::find($user_id),
            'follow_check' => $follow_check,
        ]);
    }
}

