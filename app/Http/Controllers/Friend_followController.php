<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class Friend_followController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $myId = Auth::id();
        $myAccount = User::find($myId);
        $accounts_follow = User::find($myId)->show_follow()->get();

        // $link_attach = 'follow_add_list_follow';
        // $link_detach = 'follow_release_list_follow';

        // 上とはidentify_idが違うだけ
        $identify_id = 'friend_follow';
        return view('myService.friend')->with([
            'accounts' => $accounts_follow,
            'myAccount' => $myAccount,
            // 'link_attach' => $link_attach,
            // 'link_detach' => $link_detach,
            'identify_id' => $identify_id,
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        $identify_id = $request->identify_id;
        $user_id = $request->user_id;

        $myId = Auth::id();
        $myAccount = User::find($myId);

        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかを
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $user_id)->first();
        
        // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
        $hisAccount = User::find($user_id);


        // find系列だったら(era_id)($team_id)を渡す
        // 尚detailsのみこのtalk_findとかがある
        if ($identify_id == 'find' || $identify_id == 'talk_find') {
            return view('myService.details')->with([
                'identify_id' => $identify_id,
                'hisAccount' => $hisAccount,
                'follow_check' => $follow_check,
                'era_id' => $request->era_id,
                'team_id' => $request->team_id,
            ]);
        }

        return view('myService.details')->with([
            'identify_id' => $identify_id,
            'hisAccount' => $hisAccount,
            'follow_check' => $follow_check,
        ]);
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
    public function destroy($id)
    {
        //
    }
}
