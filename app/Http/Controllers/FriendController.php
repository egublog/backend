<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Facades\IdentifyId;

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;




class FriendController extends Controller
{
    private $UserDataRepository;
    private $UserDataService;

    public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService)
    {
        $this->UserDataRepository = $UserDataRepository;
        $this->UserDataService = $UserDataService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // ここはAPI開発じゃ無いから一つのアクションに複数のユースケースを使う事になると思う
        // ここで複数のユースケースからリターンを受け取ってviewで使いやすい様にビューモデルに詰め替える事になると思う！
        $myAccount = $this->UserDataRepository->getAuthUser();

        $identify_id = $request->identify_id;

        // $identify_idによってフォローをgetするのかフォロワーを表示するのかを分ける    
        $accounts = $this->UserDataService->getAuthUserFriends($identify_id);

        return view('myService.friend')->with([
            'accounts' => $accounts,
            // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
            'myAccount' => $myAccount,
            // ↓ ここではdetails.blade.phpへ行く時に使う、多分back用  ,,全てdetailsから帰る時に使う、
            // 、あとdetailsでのトークへを表示させるかどうか、←これは副次元的に、でもどこから来たか分かっていたらめっちゃ楽
            'identify_id' => $request->identify_id,
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
        $his_id = $user->id;
        $follow_check = $this->UserDataService->AuthUserFollowCheck($his_id);
        $his_account = $this->UserDataRepository->getHisAccount($his_id);

        return view('myService.details')->with([
            'identify_id' => $request->identify_id,
            'follow_check' => $follow_check,
            'hisAccount' => $his_account,
        ]);
    }
}

