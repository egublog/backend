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
       
        return view('myService.home')->with([
            'myAccount' => $myAccount,
        ]);
    }

}
