<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\All;
use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
// use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
// use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;

use App\Services\All\Interfaces\AllDataServiceInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;



class HomeController extends Controller
{
    private $UserDataRepository;
    // private $AllDataAccess;
    private $AllDataService;
    private $UserDataService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserDataRepositoryInterface $UserDataRepository, AllDataServiceInterface $AllDataService, UserDataServiceInterface $UserDataService)
    {
        $this->middleware('auth');
        $this->UserDataRepository = $UserDataRepository;
        // $this->AllDataAccess = $AllDataAccess;
        $this->AllDataService = $AllDataService;
        $this->UserDataService = $UserDataService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $myId = $this->UserDataRepository->getAuthUserId();
        
        $this->AllDataService->saveAllFirstData($myId);

        // $this->UserDataService->saveAuthUserFirstAreaid();

        return redirect()->route('myhomes.index');

    }
}
