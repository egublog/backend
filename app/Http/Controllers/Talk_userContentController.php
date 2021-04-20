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



class Talk_userContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {


        // エラーでバリデーションのリダイレクト先がここだけど大丈夫か
        // ここから表示してコンポーネントに最小限だけ渡してエラーがあったらをtalk_show側で条件分岐すれば良いか
        // て事はtalkSendクリックイベントで必要なのはここにある最低限のデータとユーザーが打ったトークデータだけか




        //                  ↑　ここはネストしたrouteだからパラメータを取れる。
        $myId = Auth::id();
        $user_id = $user->id;

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


        // ここで相手が自分に送信したtalkテーブルのレコードのyetカラムをtrueにする、よって既読になる
        $yetColumns = Talk::where('from', $user_id)->where('to', $myId)->get();
        if (isset($yetColumns->first()->from))
            foreach ($yetColumns as $yetColumn) {
                $yetColumn->yet = true;
                $yetColumn->save();
            }

        // ここで自分と相手に関わるtalkテーブルのカラムを全て取得する。
        // $talkDatas = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'asc')->get();


        $hisAccount = User::find($user_id);



        $talkDatasDesc = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->limit(20)->with('user')->get();

        $talkDatas = $talkDatasDesc->reverse()->values();

        $identify_id = $request->identify_id;



        // ここでtalk_〇〇の値の talk_ を取る！  つまりtalk_〇〇があるのはdetails.blade.phpだけ
        if ($identify_id == 'talk_find') {
            $identify_id = 'find';
        } elseif ($identify_id == 'talk_activity') {
            $identify_id = 'activity';
        } elseif ($identify_id == 'talk_friend_follow') {
            $identify_id = 'friend_follow';
        } elseif ($identify_id == 'talk_friend_follower') {
            $identify_id = 'friend_follower';
        }


        // findだったら(era_id) (team_string)を付ける
        if ($identify_id == 'find') {
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
        //                  ↑　ここはネストしたrouteだからパラメータを取れる。
        $myId = Auth::id();
        $user_id = $user->id;


        // ここで相手が自分に送信したtalkテーブルのレコードのyetカラムをtrueにする、よって既読になる
        $yetColumns = Talk::where('from', $user_id)->where('to', $myId)->get();
        if (isset($yetColumns->first()->from))
            foreach ($yetColumns as $yetColumn) {
                $yetColumn->yet = true;
                $yetColumn->save();
            }
     
        $talkDatasDesc = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->limit(20)->with('user')->get();

        $talkDatas = $talkDatasDesc->reverse()->values();

        $hisAccount = User::find($user_id);


        $talkArray = [
            'talkDatas' => $talkDatas,
            'hisAccount' => $hisAccount,
        ];

        return response()->json(['talkArray' => $talkArray]);
  
    }



    public function axios_talkUpdate(User $user, Request $request) {


            //                  ↑　ここはネストしたrouteだからパラメータを取れる。
            $myId = Auth::id();
            $user_id = $user->id;
    
     
    
            $limitNumber = $request->pageNumber * 20;
    
            $talkDatasDesc = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->limit($limitNumber)->with('user')->get();
    
            $talkDatas = $talkDatasDesc->reverse()->values();
    
    
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

            $myId = Auth::id();

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

            if ($request->message != "") {
                $talkData = new Talk();
                $talkData->talk_data = $request->message;
                $talkData->from = $myId;
                $talkData->to = $user_id;
                $talkData->yet = false;
                $talkData->talkCheck = false;
                $talkData->save();
            }


            $talkDataOneBefore = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->offset(1)->limit(1)->first();

            // first()で取ってくると何もなかった時にnullが入ってくる。
            // get()で取ってくると何もなかった時に collectionの{#items: []}が返ってくるからその違いに注意

            $talkDataNow = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->first();

            if ($talkDataOneBefore == null) {
                $talkDataNow->talkCheck = true;
                $talkDataNow->save();
            } else {
                if ($talkDataOneBefore->created_at->format('n/j') != $talkDataNow->created_at->format('n/j')) {
                    $talkDataNow->talkCheck = true;
                    $talkDataNow->save();
                }
            }

     
        $talkDatasDesc = Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->limit(20)->with('user')->get();

        $talkDatas = $talkDatasDesc->reverse()->values();


            $hisAccount = User::find($user_id);




            // findだったらera_id, team_stringを付ける
            if ($identify_id == 'find') {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
