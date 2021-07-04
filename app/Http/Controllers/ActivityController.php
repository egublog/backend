<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;


class ActivityController extends Controller
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
    public function index()
    {
        $myAccount = $this->UserDataAccessRepository->getAuthUser();

        // 一覧表示用にフォローワーを自分をフォローしてくれた順で表示
        $accounts_follower = $this->UserDataAccessRepository->getAuthUserFollowerForActivity();

        return view('myService.activity')->with([
            'accounts_follower' => $accounts_follower,
            // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
            'myAccount' => $myAccount,
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
        $identify_id = 'activity';
        $his_id = $user->id;

        // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかを
        $follow_check = $this->UserDataAccessService->AuthUserFollowCheck($his_id);

        // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
        $his_account = $this->UserDataAccessRepository->getHisAccount($his_id);

        return view('myService.details')->with([
            'identify_id' => $identify_id,
            'hisAccount' => $his_account,
            'follow_check' => $follow_check,
        ]);
    }
}
