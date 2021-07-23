<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Facades\IdentifyId;

// use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
// use App\Services\User\Interfaces\UserDataServiceInterface;
use App\packages\UseCase\User\Get\GetAuthUsersFriendsRequest;

use App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use App\packages\UseCase\User\Get\GetAuthUsersFriendsUseCaseInterface;
use App\Http\Models\User\Get\FriendsIndexViewModel;
use App\packages\UseCase\User\Get\GetUserIdRequest;





class FriendController extends Controller
{
    // private $UserDataRepository;
    // private $UserDataService;

    // public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService)
    // {
    //     $this->UserDataRepository = $UserDataRepository;
    //     $this->UserDataService = $UserDataService;
    // }
    private $GetAuthUserUseCase;
    private $GetAuthUsersFriendsUseCase;


    public function __construct(GetAuthUserUseCaseInterface $GetAuthUserUseCase, GetAuthUsersFriendsUseCaseInterface $GetAuthUsersFriendsUseCase)
    {
        $this->GetAuthUserUseCase = $GetAuthUserUseCase;
        $this->GetAuthUsersFriendsUseCase = $GetAuthUsersFriendsUseCase;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myAccount_response = $this->GetAuthUserUseCase->handle();
        // dd($myAccount_response);

        $getAuthUsersFriendsRequest = new GetAuthUsersFriendsRequest($request->identify_id);
        // dd($getAuthUsersFriendsRequest);
        $accounts_response = $this->GetAuthUsersFriendsUseCase->handle($getAuthUsersFriendsRequest);
        // dd($accounts_response);

        // dd($accounts_response->accounts);

        $viewModel = new FriendsIndexViewModel($accounts_response->accounts, $myAccount_response->user, $getAuthUsersFriendsRequest->getIdentify_id());

        // dd($viewModel);




        // return view('myService.friend')->with([
        //     'accounts' => $accounts,
        //     // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
        //     'myAccount' => $myAccount,
        //     // ↓ ここではdetails.blade.phpへ行く時に使う、多分back用  ,,全てdetailsから帰る時に使う、
        //     // 、あとdetailsでのトークへを表示させるかどうか、←これは副次元的に、でもどこから来たか分かっていたらめっちゃ楽
        //     'identify_id' => $request->identify_id,
        // ]);

        return view('myService.friend', compact('viewModel'));

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
        // ↑ てかこれ別々にとってくる必要無いわ！！

        $getUserIdRequest = new GetUserIdRequest($user->id);
        $authUserFollowCheck_response = $this->getBooleanAuthUserFollow->handle($getUserIdRequest);
        dd(authUserFollowCheck_response->follow_check);
        // ↑ true or false

        $his_account_response = $this->getUserAccontEqualToParam->handle($getUserIdRequest);



        return view('myService.details')->with([
            'identify_id' => $request->identify_id,
            'follow_check' => $follow_check,
            'hisAccount' => $his_account,
        ]);
    }
}

