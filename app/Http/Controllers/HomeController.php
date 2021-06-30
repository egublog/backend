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


        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myId = $this->UserDataAccessRepository->getAuthUserId();
        // $myAccount = $this->UserDataAccessRepository->getAuthUser();

        // $allEra = $myAccount->alls()->where('era_id', 1)->first();
        // $allEra = $this->AllDataAccess->getAllFirst($myId);

        // if ($allEra === null) {
        //     // dd($allEra);
        //     for ($i = 1; $i < 5; $i++) {
        //         $all = new All();
        //         $all->user_id = $myId;
        //         $all->team_id = 1;
        //         $all->position_id = 1;
        //         $all->era_id = $i;
        //         $all->save();
        //     }
        // }
        $this->AllDataSaveService->saveAllFirstData($myId);

        $this->UserDataSaveService->saveAuthUserFirstAreaid();

        return redirect()->route('myhomes.index');

        // return view('home');
    }
}
