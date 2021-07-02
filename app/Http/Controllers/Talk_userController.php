<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Talk_list;
use App\Talk;
use App\Facades\IdentifyId;
use App\Facades\TalkList;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;
use App\Services\Talk_list\Interfaces\TalkListDataAccessServiceInterface;



class Talk_userController extends Controller
{

    private $UserDataAccessRepository;
    private $UserDataAccessService;
    private $TalkListDataAccessService;


    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataAccessServiceInterface $UserDataAccessService, TalkListDataAccessServiceInterface $TalkListDataAccessService)
    {
        $this->UserDataAccessRepository = $UserDataAccessRepository;
        $this->UserDataAccessService = $UserDataAccessService;
        $this->TalkListDataAccessService = $TalkListDataAccessService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 前提としてこのtalkにはトークをした事がある人だけを入れる
        // $myId = Auth::id();
        $myId = $this->UserDataAccessRepository->getAuthUserId();

        // Talk_listテーブルは左側の一覧を最近のトーク順にするためにわざわざ作ったやつ
        // （尚自分と相手のペアは一つしか出来ないようになている）
        // ↓ここではfrom to どっちもから自分に関係があるレコードを全て取得する。
        // $talk_lists = Talk_list::fromToEqual($myId)->get();


        // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる （相手のidだけが欲しいから）
        // $opponent_ids = TalkList::getOpponentIds($talk_lists, $myId);


        //  そのidをもとにfindで相手のuserを取ってきてアカウントのオブジェクトの配列を作る 順番大事！
        // $talk_lists_accounts = TalkList::getTalkListAccounts($opponent_ids);

        $talk_lists_accounts = $this->TalkListDataAccessService->getTalkListAccounts($myId);

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


        $myAccount = Auth::user();


        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかをbooleanで取得
        $follow_check = $myAccount->followCheck($user_id);

        // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
        $hisAccount = User::find($user_id);

        // つまりここから出るidentify_idは全て talk_〇〇 になる。。それがtalk_から来ましたよって事になる。
        if(!IdentifyId::talkList($identify_id)) {
            $identify_id = 'talk_'.$identify_id;
        }

         // find系列だったら(era_id)($team_id)を渡す
        // 尚detailsのみこのtalk_findとかがある
        if (IdentifyId::find($identify_id) || IdentifyId::talkFind($identify_id)) {
            return view('myService.details')->with([
                'identify_id' => $identify_id,
                'hisAccount' => $hisAccount,
                'follow_check' => $follow_check,
                'era_id' => $request->era_id,
                'team_string' => $request->team_string,
            ]);
        }
       
        return view('myService.details')->with([
            'identify_id' => $identify_id,
            'hisAccount' => $hisAccount,
            'follow_check' => $follow_check,
        ]);
    }


}
