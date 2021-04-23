<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $myAccount = Auth::user();

        // フォローする
        // $myAccount->show_follow()->attach($request->user_id);
        $myAccount->followAttach($request->user_id);
        
        // $myAccount = Auth::user();
        // if ($myAccount->image == null) {
        //     $myAccount->image = 0;
        //     $myAccount->save();
        // }

        


        // 自分のプロフィール表示用に自分のアカウント情報を付ける (myAccount)
        // 自分の画像表示用にmyIdを付ける (myId)
        return view('myService.home')->with([
            'myAccount' => $myAccount,
            // 'myId' => $myId,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        //
        $myAccount = Auth::user();

        // フォローしていたら外す、してなかったらフォローする
        // $myAccount->show_follow()->detach($user_id);
        $myAccount->followDetach($user_id);
    }
}
