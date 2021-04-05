<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Team;


class FindResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
          // $teams = Team::all();

          $myId = Auth::id();
          $myAccount = User::find($myId);
  
          // 最初のfindではidentify_idはどうやっても必要ないのでここで初めて定義
          $identify_id = 'find';
  
          // ここではまず検索して出てくるユーザーのusersテーブルを配列で取ってくるのが目的　↓
  
          //↓ ここでの一連の作業での目的はそのチーム名からワイルドカードでその文字が入っているteam_idをもらって
          // そのteam_idと入力された年代idからallsテーブルのレコード達を取得する事
          // そのall達があればfind.blade.phpで$searchAll->user->;とか、でそのuserの詳細を表示できる
  
  
          // まず検索で入力された文字列からワイルドカードで検索、合致したteamsテーブルのオブジェクトを取得(レコードの配列を)
          $teamsResults = Team::where('team', 'like', '%' . $request->team_id . '%')->get();
  
          if (isset($teamsResults)) {
              // 検索結果が帰ってくればそのオブジェクトからteamのidを取り出す なければからの配列にする。
              $team_ids = array();
              foreach ($teamsResults as $teamsResult) {
                  $team_ids[] = $teamsResult->id;
              }
              // 検索結果のera_id(年代)とそのteam_id達からallテーブルのレコードの配列を取得(allのオブジェクトの配列)
              $searchAllses = array();
              foreach ($team_ids as $team_id) {
                  $searchAllses[] = All::where('era_id', $request->era_id)->where('team_id', $team_id)->get();
              }
          } else {
              $searchAllses = '';
          }
  
          return view('myService.find')->with([
              'searchAllses' => $searchAllses,
              // ↓ 検索内容のvalue用と検索結果のdetails.blade.phpのback用(team_id)(era_id)
              'team_id' => $request->team_id,
              'era_id' => $request->era_id,
              // 'teams' => $teams,
              // ↓アカウント一覧の時に自分のアカウントは表示しない用に
              'myId' => $myId,
               // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
              'myAccount' => $myAccount,
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
