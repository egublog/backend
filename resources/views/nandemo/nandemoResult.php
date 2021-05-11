<?php



public function index(Request $request)
{
    //
      // $teams = Team::all();

    //   $myId = Auth::id();
    //   $myAccount = User::find($myId);
    $myAccount = Auth::user();

    // dd(User::where('id', 22)->get());


      // 最初のfindではidentify_idはどうやっても必要ないのでここで初めて定義
    //   ここはdetail.blade.phpだら<backボタンで戻って来た時に必要では無いかも
    //   $identify_id = 'find';

      // ここではまず検索して出てくるユーザーのusersテーブルを配列で取ってくるのが目的　↓

      //↓ ここでの一連の作業での目的はそのチーム名からワイルドカードでその文字が入っているteamsテーブルのidをもらって
      // そのteamテーブルのidと入力された年代idからallsテーブルのレコード達を取得する事
      // そのall達があればfind.blade.phpで$searchAll->user->;とか、でそのuserの詳細を表示できる


      // まず検索で入力された文字列からワイルドカードで検索、合致したteamsテーブルのオブジェクトを取得(レコードの配列を)
      // $teamsResults = Team::where('team_name', 'like', '%' . $request->team_string . '%')->get();

      // if (isset($teamsResults)) {
      //     // 検索結果が帰ってくればそのオブジェクトからteamのidを取り出す なければからの配列にする。
      //     $team_ids = array();
      //     foreach ($teamsResults as $teamsResult) {
      //         $team_ids[] = $teamsResult->id;
      //     }
      //     // 検索結果のera_id(年代)とそのteam_id達からallテーブルのレコードの配列を取得(allのオブジェクトの配列)
      //     $searchAllses = array();
      //     foreach ($team_ids as $team_id) {
      //         $searchAllses[] = All::where('era_id', $request->era_id)->where('team_id', $team_id)->get();
      //     }
      // } else {
      //     $searchAllses = '';
      // }
    //   $team_ids = Team::where('team_name', 'like', '%' . $request->team_string . '%')->pluck('id')->all();
    $team_ids = SearchTeams::get($request->team_string);

    // dd($team_ids);

    // $searchAllses[] = All::where('era_id', $request->era_id)->where('team_id', $team_id)->get();


    // foreeach($team_ids as $team_id) {
//            
    // }
    // 

    // if (isset($team_ids)) 
    //   {
    //       $searchAllses = array();
    //       foreach ($team_ids as $team_id) {
    //         $searchAllses[] = All::where('era_id', $request->era_id)->where('team_id', $team_id)->get();
    //       }
    //   } else {
    //       $searchAllses = '';
    //   }

    $searchAlls = SearchAllses::getAllArray($request->era_id, $team_ids);

    


    // dd($searchAlls);


      return view('myService.find')->with([
          'searchAlls' => $searchAlls,
          // ↓ 検索内容のvalue用と検索結果のdetails.blade.phpのback用(team_string)(era_id)
          'team_string' => $request->team_string,
          'era_id' => $request->era_id,
          // 'teams' => $teams,
          // ↓アカウント一覧の時に自分のアカウントは表示しない用に
        //   'myId' => $myId,
           // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
          'myAccount' => $myAccount,
        //   'identify_id' => $identify_id,
      ]);
}


