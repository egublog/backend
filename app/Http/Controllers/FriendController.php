<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Facades\IdentifyId;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;




class FriendController extends Controller
{
    private $UserDataAccessRepository;
    private $UserDataAccessService;

    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataAccessServiceInterface $UserDataAccessService)
    {
        $this->UserDataAccessRepository = $UserDataAccessRepository;
        $this->UserDataAccessService = $UserDataAccessService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myAccount = $this->UserDataAccessRepository->getAuthUser();

        $identify_id = $request->identify_id;

        // $identify_idによってフォローをgetするのかフォロワーを表示するのかを分ける    
        $accounts = $this->UserDataAccessService->getAuthUserFriends($identify_id);

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
        $follow_check = $this->UserDataAccessService->AuthUserFollowCheck($his_id);
        $his_account = $this->UserDataAccessRepository->getHisAccount($his_id);

        return view('myService.details')->with([
            'identify_id' => $request->identify_id,
            'follow_check' => $follow_check,
            'hisAccount' => $his_account,
        ]);
    }
}

