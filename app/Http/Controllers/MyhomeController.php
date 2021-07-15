<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Talk;
use Illuminate\Support\Arr;
use App\Repositories\User\Interfaces\UserDataRepositoryInterface;



class MyhomeController extends Controller
{
    private $UserDataRepository;


    public function __construct(UserDataRepositoryInterface $UserDataRepository)
    {
        $this->UserDataRepository = $UserDataRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myAccount = $this->UserDataRepository->getAuthUser();
        // dd($myAccount);
        // dd(User::find(Auth::id()));
        // dd(User::where('id', Auth::id())->first());
        // dd(User::where('id', Auth::id())->get());
        // dd(Auth::user());
        // dd(User::where('id', 1000)->first());

        // dd(User::where('id', Auth::id())->with('alls')->first()->alls()->get()->team();
       
        return view('myService.home')->with([
            'myAccount' => $myAccount,
        ]);
    }

}
