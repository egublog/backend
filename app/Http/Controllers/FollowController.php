<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $myAccount = Auth::user();

        // フォローする followsテーブルに自分のidと相手のidを追加する
        $myAccount->followAttach($request->user_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $myAccount = Auth::user();

        // フォローを外す followsテーブルに自分のidと相手のidを削除する
        $myAccount->followDetach($user_id);
    }
}
