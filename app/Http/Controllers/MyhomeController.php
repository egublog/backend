<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\User;
use App\Talk;
use Illuminate\Support\Arr;
// use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
// use App\packages\UseCase\User\Get\GetAuthUseUseCaseInterface;
use App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;

use App\User as UserModel;
// use packages\Domain\Domain\User\User;
// use packages\Domain\Domain\User\User;
use App\packages\Domain\Domain\User\User;
use App\Http\Models\User\Get\MyHomesIndexViewModel;
use App\Http\Models\User\Commons\UserViewModel;



class MyhomeController extends Controller
{
    // private $UserDataRepository;
    private $GetAuthUserUseCase;


    public function __construct(GetAuthUserUseCaseInterface $GetAuthUserUseCase)
    {
        // $this->UserDataRepository = $UserDataRepository;
        $this->GetAuthUserUseCase = $GetAuthUserUseCase;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $myAccount = $this->UserDataRepository->getAuthUser();
        
        // dd($myAccount);
        // dd(User::find(Auth::id()));
        // dd(User::where('id', Auth::id())->first());
        // dd(User::where('id', Auth::id())->get());
        // dd(Auth::user());
        // dd(User::where('id', 1000)->first());

        // dd(User::where('id', 3)->with('alls.team')->first()->alls->first()->team);
        // dd(User::where('id', 3)->with('alls.team')->first()->alls);

        // $user = UserModel::where('id', Auth::id())->with('alls.team')->first();
        // // dd(new User::class);

        // $myAccount = new User($user->id, $user->name, $user->email, $user->user_name, $user->age, $user->image, $user->introduction, $user->area_id, $user->created_at, $user->updated_at, $user->alls);

        // dd($myAccount->name);
            //  $response = $this->GetAuthUserUseCase->handle();

        // dd(Auth::user()->show_follow()->attach(3));



        // でここで$reponseを一般viewモデルに格納するけど今回はしない

        // $user = new UserViewModel($response->user->id, $response->user->name, $response->user->email, $response->user->user_name, $response->user->age, $response->user->image, $response->user->introduction, $response->user->area_id, $response->user->created_at, $response->user->updated_at, $response->user->alls);
            //   $user = new UserViewModel($response->user->id, $response->user->name, $response->user->email, $response->user->user_name, $response->user->age, $response->user->image, $response->user->introduction, $response->user->area_id, $response->user->created_at, $response->user->updated_at, $response->user->eras);
        // ↑  ％％でここでの詰め替えはUseCase層用のインスタンスからViewModel層用のインスタンスに詰め替えている％％


        $viewModel = new MyHomesIndexViewModel($user);

        // やはり格納し直すのはそこで使いやすい様にするから！！

        // dd($viewModel);

        // $myAccount = $viewModel;


       
        // return view('myService.home')->with([
        //     'myAccount' => $myAccount,
        // ]);
        return view('myService.home', compact('viewModel'));
        // return view('user.index', compact('viewModel'));

    }

}
