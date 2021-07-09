<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Talk_list;
use App\Talk;
use App\Http\Requests\Talk_storeRequest;
use GuzzleHttp\Psr7\LimitStream;
use Validator;
use App\Facades\IdentifyId;
use App\Facades\TalkList;
use App\Facades\CommonService;


use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;
use App\Services\Talk_list\Interfaces\TalkListDataServiceInterface;
use App\Services\Talk\Interfaces\TalkDataServiceInterface;
use App\Repositories\Talk\Interfaces\TalkDataRepositoryInterface;
// use App\Services\Talk_list\Interfaces\TalkListDataServiceInterface;





class Talk_userContentController extends Controller
{
    private $UserDataRepository;
    private $UserDataService;
    private $TalkListDataService;
    private $TalkDataService;
    private $TalkDataRepository;
    // private $TalkListDataService;


    public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService, TalkListDataServiceInterface $TalkListDataService, TalkDataServiceInterface $TalkDataService, TalkDataRepositoryInterface $TalkDataRepository)
    {
        $this->UserDataRepository = $UserDataRepository;
        $this->UserDataService = $UserDataService;
        $this->TalkListDataService = $TalkListDataService;
        $this->TalkDataService = $TalkDataService;
        $this->TalkDataRepository = $TalkDataRepository;
        // $this->TalkListDataService = $TalkListDataService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        $myId = $this->UserDataRepository->getAuthUserId();

        $user_id = $user->id;

        //  相手のuserを取ってきてアカウントのオブジェクトの配列を作る 順番大事！
        $talk_lists_accounts = $this->TalkListDataService->getTalkListAccounts($myId);

        // ここで相手が自分に送ったトークデータでTalksテーブルのyetカラムがfalseのものを取ってくる
        //   ここで$talkDatasがあればそのtalksテーブルのyetカラムをtrueにする
        $this->TalkDataService->saveYetColumnsTrue($myId, $user_id);

        $hisAccount = $this->UserDataRepository->getHisAccount($user_id);

        // ここで自分と相手のトークデータの中で最新のレコードを20個取ってくる
        $talkDatas = $this->TalkDataRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, 20);

        $identify_id = $request->identify_id;

        // ここでidentify_idのtalk_〇〇の値の talk_ を取る！  つまりtalk_〇〇があるのはdetails.blade.phpだけ
        if (IdentifyId::talkFind($identify_id)) {
            $identify_id = 'find';
        } elseif (IdentifyId::talkActivity($identify_id)) {
            $identify_id = 'activity';
        } elseif (IdentifyId::talkFriendFollow($identify_id)) {
            $identify_id = 'friend_follow';
        } elseif (IdentifyId::talkFriendFollower($identify_id)) {
            $identify_id = 'friend_follower';
        }


        // identify_idがfindだったら(era_id) (team_string)を付ける
        if (IdentifyId::find($identify_id)) {
            return view('myService.talk_show')->with([
                'talkDatas' => $talkDatas,
                'hisAccount' => $hisAccount,
                // ↓ 自分が送ったトークか相手が送ったトークかを判断するために
                'myId' => $myId,
                'user_id' => $user_id,
                'identify_id' => $identify_id,
                'era_id' => $request->era_id,
                'team_string' => $request->team_string,
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





    public function axios_userChange(User $user)
    {
        $myId = $this->UserDataRepository->getAuthUserId();

        $user_id = $user->id;

        // ここで相手が自分に送ったトークデータでTalksテーブルのyetカラムがfalseのものを取ってくる
        //   ここで$talkDatasがあればそのtalksテーブルのyetカラムをtrueにする
        $this->TalkDataService->saveYetColumnsTrue($myId, $user_id);

        // ここで自分と相手のトークデータの中で最新のレコードを20個取ってくる
        $talkDatas = $this->TalkDataRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, 20);

        $hisAccount = $this->UserDataRepository->getHisAccount($user_id);

        $talkArray = [
            'talkDatas' => $talkDatas,
            'hisAccount' => $hisAccount,
        ];

        return response()->json(['talkArray' => $talkArray]);
    }



    public function axios_talkUpdate(User $user, Request $request)
    {
        $myId = $this->UserDataRepository->getAuthUserId();

        $user_id = $user->id;

        // 無限スクロールの為の番号(pageNumber)が送られてくるからそれに20を掛ける
        $limitNumber = $request->pageNumber * 20;

        // ここで自分と相手のトークデータの中で最新のレコードを$limitNumberの数だけ取ってくる
        $talkDatas = $this->TalkDataRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, $limitNumber);

        $talkArray = [
            'talkDatas' => $talkDatas,
        ];

        return response()->json(['talkArray' => $talkArray]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Talk_storeRequest $request)
    {
        $identify_id = $request->identify_id;
        $user_id = $user->id;

        $myId = $this->UserDataRepository->getAuthUserId();

        // 自分の相手のtalk_listテーブルのレコードを更新する
        $this->TalkListDataService->updateOurTalkList($myId, $user_id);

        // 左側にトークリストを取ってくる（自分と過去にトークしたことがあるUserアカウントを）順番大事！
        $talk_lists_accounts = $this->TalkListDataService->getTalkListAccounts($myId);

        // 送信したトークデータを空のデータじゃ無かったら保存する、、 yetカラムは0を入れる
        $this->TalkDataService->saveOurTalkData($request->message, $myId, $user_id);

        // ↓ ここからの処理は非同期でもその日,初めてのトークだったらその日の日付を表示すると言う機能の為の下処理
        // その日この相手と初めてのトークだったらTalkCheckColumnをtrueにする
        $this->TalkDataService->updateOurTalkCheckColumn($myId, $user_id);


        // ここで自分と相手のトークデータの中で最新のレコードを20個取ってくる
        $talkDatas = $this->TalkDataRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, 20);

        // identify_idがfindだったらera_id, team_stringを付ける
        if (IdentifyId::find($identify_id)) {
            $talkArray = [
                'talkDatas' => $talkDatas,
                'talkListsAccounts' => $talk_lists_accounts,
            ];

            return response()->json(['talkArray' => $talkArray]);
        }

        $talkArray = [
            'talkDatas' => $talkDatas,
            'talkListsAccounts' => $talk_lists_accounts,
        ];

        return response()->json(['talkArray' => $talkArray]);
    }
}
