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

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;
use App\Services\All\Interfaces\AllDataServiceInterface;
// use App\Services\User\Interfaces\UserDataServiceInterface;




class ProfileController extends Controller
{
    private $UserDataRepository;
    private $UserDataService;
    private $AllDataService;
    // private $UserDataService;

    public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService, AllDataServiceInterface $AllDataService)
    {
        $this->UserDataRepository = $UserDataRepository;
        $this->UserDataService = $UserDataService;
        $this->AllDataService = $AllDataService;
        // $this->UserDataService = $UserDataService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // selectボタン用にareaデータを取ってくる
        $areas = $this->UserDataRepository->getAreaArray();

        $myAccount = $this->UserDataRepository->getAuthUser();

        $area_id = $this->UserDataRepository->getAuthUserAreaid();

        $schools = $this->UserDataService->returnAuthUserSchoolsArrays();

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
        // selectボタン用にareaデータを取ってくる
        $areas = $this->UserDataRepository->getAreaArray();

        $myAccount = $this->UserDataRepository->getAuthUser();

        $area_id = $this->UserDataRepository->getAuthUserAreaid();

        $schools = $this->UserDataService->returnAuthUserSchoolsArrays();

        return view('myService.profile')->with([
            'areas' => $areas,
            'myAccount' => $myAccount,
            'area_id' => $area_id,
            'schools' => $schools,
        ]);
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
        $myId = $this->UserDataRepository->getAuthUserId();

        $myAccount = $this->UserDataRepository->getAuthUser();

        // selectボタン用にareaデータを取ってくる
        $areas = $this->UserDataRepository->getAreaArray();

        // ここでチームとポジションを登録
        $this->AllDataService->saveTeamAndPosition($request, $myId);

        // ここでもしユーザーが入力してたら登録
        $this->UserDataService->saveAuthUserDataNameIntroductionAgeArea($request);

        $area_id = $this->UserDataRepository->getAuthUserAreaid();

        $schools = $this->UserDataService->returnAuthUserSchoolsArrays();

        return view('myService.profile')->with([
            'areas' => $areas,
            'myAccount' => $myAccount,
            'profile_success' => '入力された項目のプロフィールを登録しました',
            'area_id' => $area_id,
            'schools' => $schools,
        ]);
    }


}
