<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\All;

class ResultController extends Controller
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

        //   $myId = Auth::id();
        //   $myAccount = User::find($myId);
        $myAccount = Auth::user();

  
          // 最初のfindではidentify_idはどうやっても必要ないのでここで初めて定義
          $identify_id = 'find';
  
          // ここではまず検索して出てくるユーザーのusersテーブルを配列で取ってくるのが目的　↓
  
          //↓ ここでの一連の作業での目的はそのチーム名からワイルドカードでその文字が入っているteamsテーブルのidをもらって
          // そのteamテーブルのidと入力された年代idからallsテーブルのレコード達を取得する事
          // そのall達があればfind.blade.phpで$searchAll->user->;とか、でそのuserの詳細を表示できる
  
  
          // まず検索で入力された文字列からワイルドカードで検索、合致したteamsテーブルのオブジェクトを取得(レコードの配列を)
          $teamsResults = Team::where('team_name', 'like', '%' . $request->team_string . '%')->get();
  
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
              // ↓ 検索内容のvalue用と検索結果のdetails.blade.phpのback用(team_string)(era_id)
              'team_string' => $request->team_string,
              'era_id' => $request->era_id,
              // 'teams' => $teams,
              // ↓アカウント一覧の時に自分のアカウントは表示しない用に
            //   'myId' => $myId,
               // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
              'myAccount' => $myAccount,
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
        //
        $identify_id = 'find';
        $user_id = $user->id;

        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();


        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかを
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $user_id)->first();
        
        // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
        $hisAccount = User::find($user_id);


        // find系列だったら(era_id)($team_string)を渡す
        // 尚detailsのみこのtalk_findとかがある
            return view('myService.details')->with([
                'identify_id' => $identify_id,
                'hisAccount' => $hisAccount,
                'follow_check' => $follow_check,
                'era_id' => $request->era_id,
                'team_string' => $request->team_string,
            ]);

    }


}
