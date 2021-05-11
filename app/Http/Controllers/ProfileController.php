<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Area;
use App\Team;
use App\All;
use App\Http\Requests\ProfileRequest;
use App\Facades\Profile;




class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // selectボタン用にareaテーブルから全てを取ってくる (areas)
        $areas = Area::all();

        // $myId = Auth::id();
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();

        $area_id = $myAccount->area_id;



        $schools = Profile::returnSchoolsArrayes($myAccount);


        return view('myService.profile')->with([
            'areas' => $areas,
            'myAccount' => $myAccount,
            'area_id' => $area_id,
            'schools' => $schools,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        {
            $areas = Area::all();

            // $myId = Auth::id();
            // $myAccount = User::find($myId);
            $myAccount = Auth::user();

            $area_id = $myAccount->area_id;

    

            $schools = Profile::returnSchoolsArrayes($myAccount);


            return view('myService.profile')->with([
                'areas' => $areas,
                'myAccount' => $myAccount,
                'area_id' => $area_id,
                'schools' => $schools,
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        //
        {
            $myId = Auth::id();
            // $myAccount = User::find($myId);
            $myAccount = Auth::user();


            $areas = Area::all();
            // $teams = Team::all();



            Profile::saveTeamAndPosition($request, $myId);

            // ここからfindの新しい機能を追加 終了




            // ここでもしユーザーが入力してたら登録
            Profile::saveNameIntroductionAgeArea($request, $myAccount);




            $area_id = $myAccount->area_id;



            $schools = Profile::returnSchoolsArrayes($myAccount);






            return view('myService.profile')->with([
                'areas' => $areas,
                'myAccount' => $myAccount,
                'profile_success' => '入力された項目のプロフィールを登録しました',
                'area_id' => $area_id,
                'schools' => $schools,
            ]);
        }
    }
}
