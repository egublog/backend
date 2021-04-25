<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Talk_list;
use App\Facades\IdentifyId;
use App\Facades\TalkList;


class Talk_userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // 前提としてこのtalkにはトークをした事がある人だけを入れる
        // だってトークを始める時は多分　detailsからいくから！
        $myId = Auth::id();

        // $identify_id = 'talk_list';

        // Talk_listテーブルは左側の一覧を最近のトーク順にするためにわざわざ作ったやつ
        // ↓ここではfrom to どっちもから自分に関係があるレコードを全て取得する。
        // （尚自分と相手のペアは一つしか出来ないようになている）
        // $talk_lists = Talk_list::where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc')->get();
        $talk_lists = Talk_list::fromToEqual($myId)->get();


        // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる （相手のidだけが欲しいから）
        // $opponent_ids = array();
        // foreach ($talk_lists as $talk_list) {
        //     if ($talk_list->to != $myId) {
        //         $opponent_ids[] = $talk_list->to;
        //     }
        //     if ($talk_list->from != $myId) {
        //         $opponent_ids[] = $talk_list->from;
        //     }
        // }

        $opponent_ids = TalkList::getOpponentIds($talk_lists, $myId);


        //    そのidをもとにfindで相手のuserを取ってきてアカウントのオブジェクトの配列を作る 順番大事！
        // $talk_lists_accounts = array();
        // foreach ($opponent_ids as $id) {
        //     $talk_lists_accounts[] = User::find($id);
        // }

        $talk_lists_accounts = TalkList::getTalkListAccounts($opponent_ids);


        // $talk_lists_accounts = User::get()->only($account_ids);
        // ↑これだと順番がuser_id順に補正されてしまう

        return view('myService.talk')->with([
            'talk_lists_accounts' => $talk_lists_accounts,
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
        $identify_id = $request->identify_id;
        $user_id = $user->id;

        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();


        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかを
        // $follow_check = $myAccount->show_follow()->where('receive_user_id', $user_id)->first();
        $follow_check = $myAccount->followCheck($user_id);

        // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
        $hisAccount = User::find($user_id);

        // つまりここから出るidentify_idは全て talk_〇〇 になる。。それがtalk_から来ましたよって事になる。
        // if($identify_id !== 'talk_list') {
        //     $identify_id = 'talk_'.$identify_id;
        // }
        if(!IdentifyId::talkList($identify_id)) {
            $identify_id = 'talk_'.$identify_id;
        }

         // find系列だったら(era_id)($team_id)を渡す
        // 尚detailsのみこのtalk_findとかがある
        // if ($identify_id == 'find' || $identify_id == 'talk_find') {
        if (IdentifyId::find($identify_id) || IdentifyId::talkFind($identify_id)) {
            return view('myService.details')->with([
                'identify_id' => $identify_id,
                'hisAccount' => $hisAccount,
                'follow_check' => $follow_check,
                'era_id' => $request->era_id,
                'team_string' => $request->team_string,
            ]);
        }
        // if (in_array($identify_id, ['find', 'talk_find'])) {
        //     return view('myService.details')->with([
        //         'identify_id' => $identify_id,
        //         'hisAccount' => $hisAccount,
        //         'follow_check' => $follow_check,
        //         'era_id' => $request->era_id,
        //         'team_string' => $request->team_string,
        //     ]);
        // }



        return view('myService.details')->with([
            'identify_id' => $identify_id,
            'hisAccount' => $hisAccount,
            'follow_check' => $follow_check,
        ]);
    }


}
