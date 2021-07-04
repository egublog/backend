<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\All;
use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
// use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
// use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;

use App\Services\All\Interfaces\AllDataSaveServiceInterface;
use App\Services\User\Interfaces\UserDataSaveServiceInterface;



class HomeController extends Controller
{
    private $UserDataAccessRepository;
    // private $AllDataAccess;
    private $AllDataSaveService;
    private $UserDataSaveService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, AllDataSaveServiceInterface $AllDataSaveService, UserDataSaveServiceInterface $UserDataSaveService)
    {
        $this->middleware('auth');
        $this->UserDataAccessRepository = $UserDataAccessRepository;
        // $this->AllDataAccess = $AllDataAccess;
        $this->AllDataSaveService = $AllDataSaveService;
        $this->UserDataSaveService = $UserDataSaveService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $myId = $this->UserDataAccessRepository->getAuthUserId();
        
        $this->AllDataSaveService->saveAllFirstData($myId);

        $this->UserDataSaveService->saveAuthUserFirstAreaid();

        return redirect()->route('myhomes.index');

    }
}
