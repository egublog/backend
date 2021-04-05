<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\All;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        $myId = Auth::id();
        $myAccount = User::find($myId);

        $allEra = $myAccount->alls()->where('era_id', 1)->first();
        if ($allEra === null) {
            // dd($allEra);
            for ($i = 1; $i < 5; $i++) {
                $all = new All();
                $all->user_id = $myId;
                $all->team_id = 1;
                $all->position_id = 1;
                $all->era_id = $i;
                $all->save();
            }
        }

        if($myAccount->area_id === null) {
            $myAccount->area_id = 50;
            $myAccount->save();
        }

        return redirect()->route('myhomes.index');

        // return view('home');
    }
}
