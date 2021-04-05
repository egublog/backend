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
use PHPUnit\Framework\MockObject\Builder\Identity;

use function Psy\debug;

class PeopleController extends Controller
{
    //

    public function home()
    {
        $myId = Auth::id();

        // ここは登録して初めてのユーザーがきた時にusersテーブルのimageカラムに0を入れる
        // そうしないと確かエラーがでてしまう  (そのユーザが画像を登録してたら1が入る様になっている、登録していなっかったら0を入れる)
        $myAccount = User::find($myId);
        // if ($myAccount->image == null) {
        //     $myAccount->image = 0;
        //     $myAccount->save();
        // }


        // 自分のプロフィール表示用に自分のアカウント情報を付ける (myAccount)
        // 自分の画像表示用にmyIdを付ける (myId)
        return view('myService.home')->with([
            'myAccount' => $myAccount,
            'myId' => $myId,
        ]);
    }

    public function profile()
    {
        // selectボタン用にareaテーブルから全てを取ってくる (areas)
        $areas = Area::all();
   

        $myId = Auth::id();
        $myAccount = User::find($myId);

        


        // いきなり配列に$○○;を入れたらエラーになったから先に用意、またelseでいちいち書くの面倒臭いから
        $user_name = '';
        $age = '';
        $introduction = '';
        $area_id = 1;
        // でもしそのユーザがプロフィールを設定していたらその項目を$○○に渡す
        if(isset($myAccount->user_name)) {
            $user_name = $myAccount->user_name;
        }
        if(isset($myAccount->age)) {
            $age = $myAccount->age;
        }
        if(isset($myAccount->introduction)) {
            $introduction = $myAccount->introduction;
        }
        if(isset($myAccount->area_id)) {
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
       if(isset($allEra1->team_id)) {
        $elementaryTeam = $allEra1->team->team;
        $elementaryPosition = $allEra1->position_id;
       } else {
        $elementaryTeam = '';
        $elementaryPosition = 1;
       }

       if(isset($allEra2->team_id)) {
        $juniorHighTeam = $allEra2->team->team;
        $juniorHighPosition = $allEra2->position_id;
       } else {
        $juniorHighTeam = '';
        $juniorHighPosition = 1;
       }

       if(isset($allEra3->team_id)) {
        $highTeam = $allEra3->team->team;
        $highPosition = $allEra3->position_id;
       } else {
        $highTeam = '';
        $highPosition = 1;
       }

       if(isset($allEra4->team_id)) {
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
           
            'myAccount' => $myAccount,

            // 'myId' => $myId,
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


    public function find()
    {
        // 検索の変数が空だとエラーになるから入れる(era_id team_id)
        $era_id = 1;
        $team_id = '';

        return view('myService.find')->with([
            'era_id' => $era_id,
            'team_id' => $team_id,
        ]);
    }


    public function activity()
    {
        $myId = Auth::id();
        $myAccount = User::find($myId);

        // 一覧表示用にフォローワーを自分をフォローしてくれた順で表示
        $accounts_follower = User::find($myId)->show_follower_activity()->get();

        // ここのidentify_idはdetails.blade.phpに移動した時のbackとかに必要
        $identify_id = 'activity';

        return view('myService.activity')->with([
            'accounts_follower' => $accounts_follower,
            // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
            'myAccount' => $myAccount,
            'identify_id' => $identify_id,
            // ↓ フォローされた時間を表示する時にfollowテーブルの自分と相手のレコードを指定する時に使う
            // created_atを取得
            'myId' => $myId,
        ]);
    }

    public function friend_follower()
    {
        $myId = Auth::id();
        $myAccount = User::find($myId);

        // 自分をフォローしている人を取得
        $accounts_follower = User::find($myId)->show_follower()->get();

        // (ここに来る前の段階でtype=hiddenでこのidentify_idを渡せばしたの処理と合体できる)
        $identify_id = 'friend_follower';

        return view('myService.friend')->with([
            'accounts' => $accounts_follower,
            // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
            'myAccount' => $myAccount,
            // 'link_attach' => $link_attach,
            // 'link_detach' => $link_detach,
            // ↓ ここではdetails.blade.phpへ行く時に使う、多分back用  ,,全てdetailsから帰る時に使う、
            // 、後detailsでのトークへを表示させるかどうか、←これは副次元的に、でもどこから来たか分かっていたらめっちゃ楽
            'identify_id' => $identify_id,
        ]);
    }

    public function friend_follow()
    {
        $myId = Auth::id();
        $myAccount = User::find($myId);
        $accounts_follow = User::find($myId)->show_follow()->get();

        // $link_attach = 'follow_add_list_follow';
        // $link_detach = 'follow_release_list_follow';

        // 上とはidentify_idが違うだけ  あと->show_follower()と->show_follow()の違い
        $identify_id = 'friend_follow';
        return view('myService.friend')->with([
            'accounts' => $accounts_follow,
            'myAccount' => $myAccount,
            // 'link_attach' => $link_attach,
            // 'link_detach' => $link_detach,
            'identify_id' => $identify_id,
        ]);
    }


    public function details(Request $request)
    {
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



    public function talk()
    {
        // 前提としてこのtalkにはトークをした事がある人だけを入れる
        // だってトークを始める時は多分　detailsからいくから！
        $myId = Auth::id();

        $identify_id = 'talk_list';

        // Talk_listテーブルは左側の一覧を最近のトーク順にするためにわざわざ作ったやつ
        // ↓ここではfrom to どっちもから自分に関係があるレコードを全て取得する。
        // （尚自分と相手のペアは一つしか出来ないようになている）
           $talk_lists = Talk_list::where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc')->get();

           
           // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる （相手のidだけが欲しいから）
           $account_ids = array();
           foreach($talk_lists as $talk_list) {
                if($talk_list->to != $myId) {
                    $account_ids[] = $talk_list->to;
                }
                if($talk_list->from != $myId) {
                    $account_ids[] = $talk_list->from;
                }
           }
        //    そのidをもとにfindで相手のuserを取ってきてアカウントのオブジェクトの配列を作る
           $talk_lists_accounts = array();
           foreach($account_ids as $id) {
               $talk_lists_accounts[] = User::find($id);
           }
   
        return view('myService.talk')->with([
            'identify_id' => $identify_id,
            'talk_lists_accounts' => $talk_lists_accounts,
        ]);
    }



    public function talk_show(Request $request)
    {
        $myId = Auth::id();
        $user_id = $request->user_id;

        // 自分が関係しているtalk_listsテーブルを新しい順で全て撮ってくる 尚、上の処理のおかげで被っている事は無い
        $talk_lists = Talk_list::where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc')->get();

        // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる
        $account_ids = array();
        foreach($talk_lists as $talk_list) {
            if($talk_list->to != $myId) {
                $account_ids[] = $talk_list->to;
            }
            if($talk_list->from != $myId) {
                $account_ids[] = $talk_list->from;
            }
        }
    //    そのidをもとにfindでuser取ってきてアカウントのオブジェクトの配列を作る
        $talk_lists_accounts = array();
        foreach($account_ids as $id) {
            $talk_lists_accounts[] = User::find($id);
        }


        // ここで相手が自分に送信したtalkテーブルのレコードのyetカラムをtrueにする、よって既読になる
        $yetColumns = Talk::where('from', $user_id)->where('to', $myId)->get();
        if (isset($yetColumns->first()->from))
            foreach ($yetColumns as $yetColumn) {
                $yetColumn->yet = true;
                $yetColumn->save();
            }

            // ここで自分と相手に関わるtalkテーブルのカラムを全て取得する。
        $talkDatas = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->get();
        $hisAccount = User::find($user_id);

        $identify_id = $request->identify_id;

        // ここでtalk_〇〇の値のtalk_を取る！  つまりtalk_〇〇があるのはdetails.blade.phpだけ
        if($identify_id == 'talk_find') {
            $identify_id = 'find';
        } elseif($identify_id == 'talk_activity') {
            $identify_id = 'activity';
        } elseif($identify_id == 'talk_friend_follow') {
            $identify_id = 'friend_follow';
        } elseif($identify_id == 'talk_friend_follower') {
            $identify_id = 'friend_follower';
        } 


        // findだったら(era_id) (team_id)を付ける
        if ($identify_id == 'find') {
            return view('myService.talk_show')->with([
                'talkDatas' => $talkDatas,
                'hisAccount' => $hisAccount,
                // ↓ 自分が送ったトークか相手が送ったトークかを判断するために
                'myId' => $myId,
                // 'user_id' => $user_id,⇦これ要らない。hisAccount->idで取れるから3/23
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
        ]);;
    }


    
}
