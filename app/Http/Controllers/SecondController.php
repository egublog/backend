<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Person;
use App\All;
use App\Area;
use App\Team;
use App\User;
use App\Follow;
use App\Talk;
use App\Talk_list;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\FindRequest;
// use App\Http\Requests\Talk_storeRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Redirect;

class SecondController extends Controller
{
    //



    public function find_return(FindRequest $request)
    {
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


    public function follow_switch_list(Request $request)
    {
        $myId = Auth::id();
        $myAccount = User::find($myId);

        // その人を自分がフォローしているかどうかを調べる
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $request->user_id)->first();

        // フォローしていたら外す、してなかったらフォローする
        if (isset($follow_check)) {
            $myAccount->show_follow()->detach($request->user_id);
        } else {
            $myAccount->show_follow()->attach($request->user_id);
        }

        $identify_id = $request->identify_id;

        // identify_idがfindの場合はこれが必要 他はなんもいらない(一覧表示で$変数が必要なのはfind_returnから来たやつだけ)
        if ($identify_id == 'find') {
            $finds = array(
                'era_id' => $request->era_id,
                'team_id' => $request->team_id,
                'identify_id' => $identify_id,
            );
        }

        if ($identify_id == 'friend_follow') {
            return redirect('/players/people/friend_follow');
        } elseif ($identify_id == 'friend_follower') {
            return redirect('/players/people/friend_follower');
        } elseif ($identify_id == 'activity') {
            return redirect('/players/people/activity');
        } elseif ($identify_id == 'find') {
            return redirect()->action('SecondController@find_return', $finds);
        }
    }


    public function follow_switch_details(Request $request)
    {
        $user_id = $request->user_id;
        $identify_id = $request->identify_id;

        $myId = Auth::id();
        $myAccount = User::find($myId);

        // 自分がフォローしているかどうかを調べる
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $request->user_id)->first();

        // フォローしていたら外す、してなかったらフォローする
        if (isset($follow_check)) {
            $myAccount->show_follow()->detach($request->user_id);
        } else {
            $myAccount->show_follow()->attach($request->user_id);
        }

        // details.blade.phpへ帰るやつだから一覧表示じゃないからここでfollow_checkをしてあげる
        $follow_check = $myAccount->show_follow()->where('receive_user_id', $user_id)->first();

        $hisAccount = User::find($user_id);

        // find系はera_id,team_idをあげる
        if ($identify_id == 'find' || $identify_id == 'talk_find') {
            return view('myService.details')->with([
                'hisAccount' => $hisAccount,
                'follow_check' => $follow_check,
                'team_id' => $request->team_id,
                'era_id' => $request->era_id,
                // 'myId' => $myId,
                'identify_id' => $identify_id,
            ]);
        }

        return view('myService.details')->with([
            'hisAccount' => $hisAccount,
            'follow_check' => $follow_check,
            'identify_id' => $identify_id,
        ]);
    }



    public function talk_store(Request $request)
    {

        $myId = Auth::id();

        $user_id = $request->user_id;

        // トークを送信したタイミングで自分と相手のtalk_listを取ってくる
        $existing_talk_list =  Talk_list::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->first();
        
        // それがあればtalk_listsテーブルに$myId or $user_id が会ったら消す
        if (isset($existing_talk_list)) {
            $existing_talk_list->delete();
        }

        // で新しくtalk_listsテーブルに追加する。
        $new_talk_list = new Talk_list();
        $new_talk_list->from = $myId;
        $new_talk_list->to = $user_id;
        $new_talk_list->save();

        // 自分が関係しているtalk_listsテーブルを新しい順で全て撮ってくる 尚、上の処理のおかげで被っている事は無い
        $talk_lists = Talk_list::where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc')->get();

        // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる
        $account_ids = array();
        foreach ($talk_lists as $talk_list) {
            if ($talk_list->to != $myId) {
                $account_ids[] = $talk_list->to;
            }
            if ($talk_list->from != $myId) {
                $account_ids[] = $talk_list->from;
            }
        }
        //    そのidをもとにfindでuser取ってきてアカウントのオブジェクトの配列を作る
        $talk_lists_accounts = array();
        foreach ($account_ids as $id) {
            $talk_lists_accounts[] = User::find($id);
        }


        // 送信したトークデータを空のデータじゃ無かったら保存する、、 yetカラムは0を入れる 多分falseでもいい
        $talkData = new Talk();
        $talkData->talk_data = $request->message;
        $talkData->from = $myId;
        $talkData->to = $request->user_id;
        $talkData->yet = 0;

        if ($request->message != "") {
            $talkData->save();
        }


        // 自分と相手のtalkデータを取ってくる
        $talkDatas = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->get();
        $hisAccount = User::find($user_id);

        $identify_id = $request->identify_id;

        // findだったらera_id, team_idを付ける
        if ($identify_id == 'find') {
            return view('myService.talk_show')->with([
                'talkDatas' => $talkDatas,
                'hisAccount' => $hisAccount,
                'myId' => $myId,
                'user_id' => $user_id,
             
                'identify_id' => $identify_id,

                'era_id' => $request->era_id,
                'team_id' => $request->team_id,
                'talk_lists_accounts' => $talk_lists_accounts,
            ]);
        }

        return view('myService.talk_show')->with([
            'talkDatas' => $talkDatas,
            'hisAccount' => $hisAccount,
            'myId' => $myId,
            'user_id' => $user_id,
        
            'identify_id' => $identify_id,
            'talk_lists_accounts' => $talk_lists_accounts,
        ]);
    }


    public function image_store(ImageRequest $request)
    {
        // プロフィールの都道府県設定用にareasテーブルから全てのデータを取ってくる
        $areas = Area::all();
        // $teams = Team::all();

        $myId = Auth::id();
        $myAccount = User::find($myId);
        //↓ 最初にimageカラムを0にしているので画像があることを判らせるためにimageカラムに1を入れる
        $myAccount->image = 1;
        $myAccount->save();

        // ここで画像をasokoへ保存する 尚、元から画像があっても自動でアップデートしてくれる
        $request->image->storeAs('public/profile_images', Auth::id() . '.jpg');

         // いきなり配列に$○○;を入れたらエラーになったから先に用意、またelseでいちいち書くの面倒臭いから
        $user_name = '';
        $age = '';
        $introduction = '';
        $area_id = 1;

    
        if (isset($myAccount->user_name)) {
            $user_name = $myAccount->user_name;
        }
        if (isset($myAccount->age)) {
            $age = $myAccount->age;
        }
        if (isset($myAccount->introduction)) {
            $introduction = $myAccount->introduction;
        }
        if (isset($myAccount->area_id)) {
            $area_id = $myAccount->area_id;
        }


           // 自分のアカウントのallを年代別に取得、、こうやってわざわざ先にfirst()で取っときて
        // 変数に代入しないと、その先のリレーションがカラムを取得と勘違いされてしまう。
        $allEra1 = $myAccount->alls()->where('era_id', 1)->first();
        $allEra2 = $myAccount->alls()->where('era_id', 2)->first();
        $allEra3 = $myAccount->alls()->where('era_id', 3)->first();
        $allEra4 = $myAccount->alls()->where('era_id', 4)->first();

          // allのチームidがある → つまりチームが登録されていたらそのチーム名を代入して、ポジションも代入する
        // 無かったら空と1を代入する
        if (isset($allEra1->team_id)) {
            $elementaryTeam = $allEra1->team->team;
            $elementaryPosition = $allEra1->position_id;
        } else {
            $elementaryTeam = '';
            $elementaryPosition = 1;
        }

        if (isset($allEra2->team_id)) {
            $juniorHighTeam = $allEra2->team->team;
            $juniorHighPosition = $allEra2->position_id;
        } else {
            $juniorHighTeam = '';
            $juniorHighPosition = 1;
        }

        if (isset($allEra3->team_id)) {
            $highTeam = $allEra3->team->team;
            $highPosition = $allEra3->position_id;
        } else {
            $highTeam = '';
            $highPosition = 1;
        }

        if (isset($allEra4->team_id)) {
            $universityTeam = $allEra4->team->team;
            $universityPosition = $allEra4->position_id;
        } else {
            $universityTeam = '';
            $universityPosition = 1;
        }



         //    これはprofile.blade.php側で使うやつbladeで定義はいけてないからここで作る。
        $schools = array(
            array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
            array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
            array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
            array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
        );


        return view('myService.profile')->with([
            'areas' => $areas,
            // 'teams' => $teams,
            // ↓ myAccount->image用
            'myAccount' => $myAccount,
            // 'myId' => $myId,
            'image_success' => '新しいプロフィール画像を登録しました',
               // ここから下 ↓ はvauleで使う
            'user_name' => $user_name,
            'age' => $age,
            'introduction' => $introduction,
            'area_id' => $area_id,
            // 'elementaryTeam' => $elementaryTeam,
            // 'juniorHighTeam' => $juniorHighTeam,
            // 'highTeam' => $highTeam,
            // 'universityTeam' => $universityTeam,
            // 'elementaryPosition' => $elementaryPosition,
            // 'juniorHighPosition' => $juniorHighPosition,
            // 'highPosition' => $highPosition,
            // 'universityPosition' => $universityPosition,

            'schools' => $schools,
        ]);
    }



    public function image_store_error()
    {

        $areas = Area::all();
        // $teams = Team::all();

        $myId = Auth::id();
        $myAccount = User::find($myId);

        // こっちではエラー版だからトークデータの保存とかはしない


        $user_name = '';
        $age = '';
        $introduction = '';
        $area_id = 1;

       
        if (isset($myAccount->user_name)) {
            $user_name = $myAccount->user_name;
        }
        if (isset($myAccount->age)) {
            $age = $myAccount->age;
        }
        if (isset($myAccount->introduction)) {
            $introduction = $myAccount->introduction;
        }
        if (isset($myAccount->area_id)) {
            $area_id = $myAccount->area_id;
        }


        $allEra1 = $myAccount->alls()->where('era_id', 1)->first();
        $allEra2 = $myAccount->alls()->where('era_id', 2)->first();
        $allEra3 = $myAccount->alls()->where('era_id', 3)->first();
        $allEra4 = $myAccount->alls()->where('era_id', 4)->first();


        if (isset($allEra1->team_id)) {
            $elementaryTeam = $allEra1->team->team;
            $elementaryPosition = $allEra1->position_id;
        } else {
            $elementaryTeam = '';
            $elementaryPosition = 1;
        }

        if (isset($allEra2->team_id)) {
            $juniorHighTeam = $allEra2->team->team;
            $juniorHighPosition = $allEra2->position_id;
        } else {
            $juniorHighTeam = '';
            $juniorHighPosition = 1;
        }

        if (isset($allEra3->team_id)) {
            $highTeam = $allEra3->team->team;
            $highPosition = $allEra3->position_id;
        } else {
            $highTeam = '';
            $highPosition = 1;
        }

        if (isset($allEra4->team_id)) {
            $universityTeam = $allEra4->team->team;
            $universityPosition = $allEra4->position_id;
        } else {
            $universityTeam = '';
            $universityPosition = 1;
        }


        $schools = array(
            array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
            array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
            array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
            array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
        );




        return view('myService.profile')->with([
            'areas' => $areas,
            // 'teams' => $teams,
            'myAccount' => $myAccount,
            // 'myId' => $myId,
            'user_name' => $user_name,
            'age' => $age,
            'introduction' => $introduction,
            'area_id' => $area_id,
            // 'elementaryTeam' => $elementaryTeam,
            // 'juniorHighTeam' => $juniorHighTeam,
            // 'highTeam' => $highTeam,
            // 'universityTeam' => $universityTeam,
            // 'elementaryPosition' => $elementaryPosition,
            // 'juniorHighPosition' => $juniorHighPosition,
            // 'highPosition' => $highPosition,
            // 'universityPosition' => $universityPosition,

            'schools' => $schools,
        ]);
    }



    public function profile_store(ProfileRequest $request)
    {
        $myId = Auth::id();
        $myAccount = User::find($myId);

        $areas = Area::all();
        // $teams = Team::all();


     
        $schools = array(
            array(1, $request->elementaryTeam, $request->elementaryPosition),
            array(2, $request->juniorHighTeam, $request->juniorHighPosition),
            array(3, $request->highTeam, $request->highPosition),
            array(4, $request->universityTeam, $request->universityPosition)
        );

        foreach ($schools as $school) {

            // まずprofileでユーザーがチーム名を入力したかを年代別に確かめる、入力してたら次の処理をする
            if (isset($school[1])) {

                
                // 入力したチーム名のteamsテーブルのカラム一つ
                $teamAlready = Team::where('team', $school[1])->first();
                
                // 既にteamsテーブルに入力されたチーム名があるかを確認する、なかったらそのチーム名をteamsテーブル新規追加する。
                // そしてそのidを取ってくる
                // あったら既存のそのidを取ってくる
                if (isset($teamAlready)) {
                    $team_id = $teamAlready->id;
                } else {
                    $team = new Team();
                    $team->team = $school[1];
                    $team->save();

                    $theTeam = Team::where('team', $school[1])->first();
                    $team_id = $theTeam->id;
                }
                // 上↑はteamsテーブルへのチームの登録処理、、とそのidの取得（そのidを自分をallsテーブルに入れるから）



                // そいつがもう既にチームを登録しているかを確認（年代別に確認）
                //  既に登録していたら上書き していなかったら新しく作って保存
                $all = All::where('user_id', $myId)->where('era_id', $school[0])->first();
                // era_idだけだと、チーム名が入力されていなくても登録されるためちゃんとチームidで調べる
                if (isset($all->team_id)) {
                    // $all->user_id = $myId;

                    $all->team_id = $team_id;

                    $all->position_id = $school[2];

                    $all->era_id = $school[0];
                    $all->save();
                } else {
                    $all = new All();
                    $all->user_id = $myId;
                    $all->team_id = $team_id;
                    $all->position_id = $school[2];
                    $all->era_id = $school[0];
                    $all->save();
                }
            } // if ($school[1])

        } // foreach

        // ここからfindの新しい機能を追加 終了




          // ここでもしユーザーが入力してたら登録
          $columns = array('user_name', 'introduction', 'age', 'area_id');
          foreach ($columns as $column) {
              if (isset($request->$column)) {
                  $myAccount->$column = $request->$column;
              }
          }
          $myAccount->save();

        $user_name = '';
        $age = '';
        $introduction = '';
        $area_id = 1;


        if (isset($myAccount->user_name)) {
            $user_name = $myAccount->user_name;
        }
        if (isset($myAccount->age)) {
            $age = $myAccount->age;
        }
        if (isset($myAccount->introduction)) {
            $introduction = $myAccount->introduction;
        }
        if (isset($myAccount->area_id)) {
            $area_id = $myAccount->area_id;
        }


        $allEra1 = $myAccount->alls()->where('era_id', 1)->first();
        $allEra2 = $myAccount->alls()->where('era_id', 2)->first();
        $allEra3 = $myAccount->alls()->where('era_id', 3)->first();
        $allEra4 = $myAccount->alls()->where('era_id', 4)->first();


        if (isset($allEra1->team_id)) {
            $elementaryTeam = $allEra1->team->team;
            $elementaryPosition = $allEra1->position_id;
        } else {
            $elementaryTeam = '';
            $elementaryPosition = 1;
        }

        if (isset($allEra2->team_id)) {
            $juniorHighTeam = $allEra2->team->team;
            $juniorHighPosition = $allEra2->position_id;
        } else {
            $juniorHighTeam = '';
            $juniorHighPosition = 1;
        }

        if (isset($allEra3->team_id)) {
            $highTeam = $allEra3->team->team;
            $highPosition = $allEra3->position_id;
        } else {
            $highTeam = '';
            $highPosition = 1;
        }

        if (isset($allEra4->team_id)) {
            $universityTeam = $allEra4->team->team;
            $universityPosition = $allEra4->position_id;
        } else {
            $universityTeam = '';
            $universityPosition = 1;
        }


        $schools = array(
            array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
            array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
            array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
            array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
        );





        return view('myService.profile')->with([
            'areas' => $areas,
            // 'teams' => $teams,
            'myAccount' => $myAccount,
            // 'myId' => $myId,
            'profile_success' => '入力された項目のプロフィールを登録しました',
            'user_name' => $user_name,
            'age' => $age,
            'introduction' => $introduction,
            'area_id' => $area_id,
            // 'elementaryTeam' => $elementaryTeam,
            // 'juniorHighTeam' => $juniorHighTeam,
            // 'highTeam' => $highTeam,
            // 'universityTeam' => $universityTeam,
            // 'elementaryPosition' => $elementaryPosition,
            // 'juniorHighPosition' => $juniorHighPosition,
            // 'highPosition' => $highPosition,
            // 'universityPosition' => $universityPosition,

            'schools' => $schools,
        ]);
    }


    public function profile_store_error()
    {
        $myId = Auth::id();
        $myAccount = User::find($myId);

        $areas = Area::all();
        $teams = Team::all();

        // こっちはエラー版なのでプロフィールの登録処理関連はいらない


        $user_name = '';
        $age = '';
        $introduction = '';
        $area_id = 1;


        if (isset($myAccount->user_name)) {
            $user_name = $myAccount->user_name;
        }
        if (isset($myAccount->age)) {
            $age = $myAccount->age;
        }
        if (isset($myAccount->introduction)) {
            $introduction = $myAccount->introduction;
        }
        if (isset($myAccount->area_id)) {
            $area_id = $myAccount->area_id;
        }


        $allEra1 = $myAccount->alls()->where('era_id', 1)->first();
        $allEra2 = $myAccount->alls()->where('era_id', 2)->first();
        $allEra3 = $myAccount->alls()->where('era_id', 3)->first();
        $allEra4 = $myAccount->alls()->where('era_id', 4)->first();


        if (isset($allEra1->team_id)) {
            $elementaryTeam = $allEra1->team->team;
            $elementaryPosition = $allEra1->position_id;
        } else {
            $elementaryTeam = '';
            $elementaryPosition = 1;
        }

        if (isset($allEra2->team_id)) {
            $juniorHighTeam = $allEra2->team->team;
            $juniorHighPosition = $allEra2->position_id;
        } else {
            $juniorHighTeam = '';
            $juniorHighPosition = 1;
        }

        if (isset($allEra3->team_id)) {
            $highTeam = $allEra3->team->team;
            $highPosition = $allEra3->position_id;
        } else {
            $highTeam = '';
            $highPosition = 1;
        }

        if (isset($allEra4->team_id)) {
            $universityTeam = $allEra4->team->team;
            $universityPosition = $allEra4->position_id;
        } else {
            $universityTeam = '';
            $universityPosition = 1;
        }

        $schools = array(
            array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
            array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
            array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
            array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
        );



        return view('myService.profile')->with([
            'areas' => $areas,
            // 'teams' => $teams,
            'myAccount' => $myAccount,
            // 'myId' => $myId,
             // 'profile_success' => '入力された項目のプロフィールを登録しました',
            'user_name' => $user_name,
            'age' => $age,
            'introduction' => $introduction,
            'area_id' => $area_id,
            // 'elementaryTeam' => $elementaryTeam,
            // 'juniorHighTeam' => $juniorHighTeam,
            // 'highTeam' => $highTeam,
            // 'universityTeam' => $universityTeam,
            // 'elementaryPosition' => $elementaryPosition,
            // 'juniorHighPosition' => $juniorHighPosition,
            // 'highPosition' => $highPosition,
            // 'universityPosition' => $universityPosition,

            'schools' => $schools,
        ]);
    }
}
