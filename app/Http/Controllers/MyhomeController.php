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
        $response = $this->GetAuthUserUseCase->handle();

        // でここで$reponseを一般viewモデルに格納するけど今回はしない

        $viewModel = new MyHomesIndexViewModel($response);

        dd($viewModel);

        $myAccount = $viewModel;


       
        return view('myService.home')->with([
            'myAccount' => $myAccount,
        ]);
    }

}
