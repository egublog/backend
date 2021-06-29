<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Talk;
use Illuminate\Support\Arr;
use App\Repositories\User\Interfaces\UserDataAccessInterface;



class MyhomeController extends Controller
{

    private $UserDataAccess;


    public function __construct(UserDataAccessInterface $UserDataAccess)
    {
        $this->UserDataAccess = $UserDataAccess;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $myAccount = Auth::user();
        $myAccount = $this->UserDataAccess->getAuthUser();
       
        // 自分のプロフィール表示用に自分のアカウント情報を付ける (myAccount)
        return view('myService.home')->with([
            'myAccount' => $myAccount,
        ]);
    }

}
