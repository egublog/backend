<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myAccount = Auth::user();

        // 一覧表示用にフォローワーを自分をフォローしてくれた順で表示
        $accounts_follower = $myAccount->getFollowerActivity();
        
        return view('myService.activity')->with([
            'accounts_follower' => $accounts_follower,
            // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
            'myAccount' => $myAccount,
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
        $identify_id = 'activity';
        $user_id = $user->id;
        
        $myAccount = Auth::user();

        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかを
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
