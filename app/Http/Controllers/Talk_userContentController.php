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


use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;
use App\Services\Talk_list\Interfaces\TalkListDataAccessServiceInterface;
use App\Services\Talk\Interfaces\TalkDataSaveServiceInterface;
use App\Repositories\Talk\Interfaces\TalkDataAccessRepositoryInterface;
use App\Services\Talk_list\Interfaces\TalkListDataSaveServiceInterface;





class Talk_userContentController extends Controller
{


    private $UserDataAccessRepository;
    private $UserDataAccessService;
    private $TalkListDataAccessService;
    private $TalkDataSaveService;
    private $TalkDataAccessRepository;
    private $TalkListDataSaveService;


    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataAccessServiceInterface $UserDataAccessService, TalkListDataAccessServiceInterface $TalkListDataAccessService, TalkDataSaveServiceInterface $TalkDataSaveService, TalkDataAccessRepositoryInterface $TalkDataAccessRepository, TalkListDataSaveServiceInterface $TalkListDataSaveService)
    {
        $this->UserDataAccessRepository = $UserDataAccessRepository;
        $this->UserDataAccessService = $UserDataAccessService;
        $this->TalkListDataAccessService = $TalkListDataAccessService;
        $this->TalkDataSaveService = $TalkDataSaveService;
        $this->TalkDataAccessRepository = $TalkDataAccessRepository;
        $this->TalkListDataSaveService = $TalkListDataSaveService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        //                  ↑ ここはネストしたrouteだからパラメータを取れる。


        // エラーでバリデーションのリダイレクト先がここだけど大丈夫か
        // ここから表示してコンポーネントに最小限だけ渡してエラーがあったらをtalk_show側で条件分岐すれば良いか
        // て事はtalkSendクリックイベントで必要なのはここにある最低限のデータとユーザーが打ったトークデータだけか


        // $myId = Auth::id();
        $myId = $this->UserDataAccessRepository->getAuthUserId();

        $user_id = $user->id;

        // 自分が関係しているtalk_listsテーブルを新しい順で全て撮ってくる 尚、Talk_listsテーブルへの保存方法のおかげで被っている事は無い
        // $talk_lists = Talk_list::fromToEqual($myId)->get();

        // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる
        // $opponent_ids = TalkList::getOpponentIds($talk_lists, $myId);



        //  そのidをもとにfindで相手のuserを取ってきてアカウントのオブジェクトの配列を作る 順番大事！
        // $talk_lists_accounts = TalkList::getTalkListAccounts($opponent_ids);

        $talk_lists_accounts = $this->TalkListDataAccessService->getTalkListAccounts($myId);





        // ここで相手が自分に送ったトークデータでTalksテーブルのyetカラムがfalseのものを取ってくる
        // $talkDatas = Talk::yetColumnsFalse($myId, $user_id)->get();

        //   ここで$talkDatasがあればそのtalksテーブルのyetカラムをtrueにする
        // if ($talkDatas) {
        //     TalkList::changeYetColumnsTrue($talkDatas);
        // }

        $this->TalkDataSaveService->saveYetColumnsTrue($myId, $user_id);



        // $hisAccount = User::find($user_id);
        $hisAccount = $this->UserDataAccessRepository->getHisAccount($user_id);


        // ここで自分と相手のトークデータの中で最新のレコードを20個取ってくる
        // $talkDatasDesc = Talk::TalkDatasLatestLimit($myId, $user_id, 20)->with('user')->get();

        // トークは古いのが一番上でそこから新しくなるから最新のトークデータを古い順に並び変える
        // $talkDatas = CommonService::reverseCollection($talkDatasDesc);
        $talkDatas = $this->TalkDataAccessRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, 20);

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
        //                  ↑ ここはネストしたrouteだからパラメータを取れる。
        // $myId = Auth::id();
        $myId = $this->UserDataAccessRepository->getAuthUserId();

        $user_id = $user->id;




        // ここで相手が自分に送ったトークデータでTalksテーブルのyetカラムがfalseのものを取ってくる
        // $talkDatas = Talk::yetColumnsFalse($myId, $user_id)->get();

        //   ここで$talkDatasがあればそのtalksテーブルのyetカラムをtrueにする
        // if ($talkDatas) {
        //     TalkList::changeYetColumnsTrue($talkDatas);
        // }
        $this->TalkDataSaveService->saveYetColumnsTrue($myId, $user_id);


        // ここで自分と相手のトークデータの中で最新のレコードを20個取ってくる
        // $talkDatasDesc = Talk::TalkDatasLatestLimit($myId, $user_id, 20)->with('user')->get();

        // トークは古いのが一番上でそこから新しくなるから最新のトークデータを古い順に並び帰る
        // $talkDatas = CommonService::reverseCollection($talkDatasDesc);
        $talkDatas = $this->TalkDataAccessRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, 20);



        // $hisAccount = User::find($user_id);
        $hisAccount = $this->UserDataAccessRepository->getHisAccount($user_id);



        $talkArray = [
            'talkDatas' => $talkDatas,
            'hisAccount' => $hisAccount,
        ];

        return response()->json(['talkArray' => $talkArray]);
    }



    public function axios_talkUpdate(User $user, Request $request)
    {
        //                  ↑ ここはネストしたrouteだからパラメータを取れる。
        // $myId = Auth::id();
        $myId = $this->UserDataAccessRepository->getAuthUserId();

        $user_id = $user->id;

        // 無限スクロールの為の番号(pageNumber)が送られてくるからそれに20を掛ける
        $limitNumber = $request->pageNumber * 20;

        // ここで自分と相手のトークデータの中で最新のレコードを$limitNumberの数だけ取ってくる
        // $talkDatasDesc = Talk::TalkDatasLatestLimit($myId, $user_id, $limitNumber)->with('user')->get();

        // トークは古いのが一番上でそこから新しくなるから最新のトークデータを古い順に並び帰る
        // $talkDatas = CommonService::reverseCollection($talkDatasDesc);
        $talkDatas = $this->TalkDataAccessRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, $limitNumber);


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
        //
        {
            //


            $identify_id = $request->identify_id;
            $user_id = $user->id;

            // $myId = Auth::id();
            $myId = $this->UserDataAccessRepository->getAuthUserId();


            // トークを送信したタイミングで自分と相手のtalk_listテーブルのレコードを取ってくる
            // $existing_talk_list =  Talk_list::ourTalkList($myId, $user_id)->first();

            // それがあればtalk_listsテーブルに$myId or $user_id が会ったら消す
            // if (isset($existing_talk_list)) {
            //     $existing_talk_list->delete();
            // }

            // で新しくtalk_listsテーブルに自分と相手のidを追加する 。
            // $new_talk_list = new Talk_list();
            // $new_talk_list->saveNewTalkList($myId, $user_id);

            $this->TalkListDataSaveService->updateOurTalkList($myId, $user_id);

            // 自分が関係しているtalk_listsテーブルを新しい順で全て撮ってくる 尚、Talk_listsテーブルへの保存方法のおかげで被っている事は無い
            // $talk_lists = Talk_list::fromToEqual($myId)->get();


            // その中で自分のidじゃ無いidだけ撮って来て配列$account_idsに入れる
            // $opponent_ids = TalkList::getOpponentIds($talk_lists, $myId);
            // ↑ 参画 これはカスタムCollectionを使えばわざわざファサードからやらなくても$talk_list->で実行できる

            //  そのidをもとにfindでuser取ってきてアカウントのオブジェクトの配列を作る  順番大事！
            // $talk_lists_accounts = TalkList::getTalkListAccounts($opponent_ids);
            $talk_lists_accounts = $this->TalkListDataAccessService->getTalkListAccounts($myId);




            // 送信したトークデータを空のデータじゃ無かったら保存する、、 yetカラムは0を入れる
            // if ($request->message != "") {
            //     $talkData = new Talk();
            //     $talkData->saveNewTalk($request->message, $myId, $user_id);
            // }
            $this->TalkDataSaveService->saveOurTalkData($request->message, $myId, $user_id);

            // ↓ ここからの処理は非同期でもその日,初めてのトークだったらその日の日付を表示すると言う機能の為の下処理

            // ここでは自分と相手のトークデータの最新の一個前のレコードを取ってくる
            // $talkDataOneBefore = Talk::TalkDataOneBefore($myId, $user_id)->first();

            // first()で取ってくると何もなかった時にnullが入ってくる。
            // get()で取ってくると何もなかった時に collectionの{#items: []}が返ってくるからその違いに注意

            // ここでは自分と相手のトークデータの最新のレコードを取ってくる
            // $talkDataNow = Talk::TalkDataNow($myId, $user_id)->first();

            // $talkDataOneBeforeと$talkDataNowの日付を比較して同じだったらtalkCheckカラム(boolean型)にfalse違ったらtrueをいれる($talkDataOneBeforeが存在しなかった場合はtrueをいれる）
            // $talkDataNow->saveTalkCheckColumn($talkDataOneBefore);
            $this->TalkDataSaveService->updateOurTalkCheckColumn($myId, $user_id);


            // ここで自分と相手のトークデータの中で最新のレコードを20個取ってくる
            // $talkDatasDesc = Talk::TalkDatasLatestLimit($myId, $user_id, 20)->with('user')->get();

            // トークは古いのが一番上でそこから新しくなるから最新のトークデータを古い順に並び変える
            // $talkDatas = CommonService::reverseCollection($talkDatasDesc);
            $talkDatas = $this->TalkDataAccessRepository->getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, 20);



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
}
