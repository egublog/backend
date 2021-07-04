<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Talk;
use Illuminate\Support\Arr;
use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;



class MyhomeController extends Controller
{
    private $UserDataAccessRepository;


    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository)
    {
        $this->UserDataAccessRepository = $UserDataAccessRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myAccount = $this->UserDataAccessRepository->getAuthUser();
       
        return view('myService.home')->with([
            'myAccount' => $myAccount,
        ]);
    }

}
