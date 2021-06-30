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

    private $UserDataAccess;
    // private $AllDataAccess;
    private $AllDataSave;
    private $UserDataSave;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserDataAccessRepositoryInterface $UserDataAccess, AllDataSaveServiceInterface $AllDataSave, UserDataSaveServiceInterface $UserDataSave)
    {
        $this->middleware('auth');
        $this->UserDataAccess = $UserDataAccess;
        // $this->AllDataAccess = $AllDataAccess;
        $this->AllDataSave = $AllDataSave;
        $this->UserDataSave = $UserDataSave;
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
        $myId = $this->UserDataAccess->getAuthUserId();
        $myAccount = $this->UserDataAccess->getAuthUser();

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
        $this->AllDataSave->saveAllFirstData($myId);

        $this->UserDataSave->saveAuthUserFirstAreaid();

        return redirect()->route('myhomes.index');

        // return view('home');
    }
}
