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

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;
use App\Services\All\Interfaces\AllDataSaveServiceInterface;
use App\Services\User\Interfaces\UserDataSaveServiceInterface;




class ProfileController extends Controller
{
    private $UserDataAccessRepository;
    private $UserDataAccessService;
    private $AllDataSaveService;
    private $UserDataSaveService;

    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataAccessServiceInterface $UserDataAccessService, AllDataSaveServiceInterface $AllDataSaveService, UserDataSaveServiceInterface $UserDataSaveService)
    {
        $this->UserDataAccessRepository = $UserDataAccessRepository;
        $this->UserDataAccessService = $UserDataAccessService;
        $this->AllDataSaveService = $AllDataSaveService;
        $this->UserDataSaveService = $UserDataSaveService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // selectボタン用にareaデータを取ってくる
        $areas = $this->UserDataAccessRepository->getAreaArray();

        $myAccount = $this->UserDataAccessRepository->getAuthUser();

        $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

        $schools = $this->UserDataAccessService->returnAuthUserSchoolsArrays();

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
        $areas = $this->UserDataAccessRepository->getAreaArray();

        $myAccount = $this->UserDataAccessRepository->getAuthUser();

        $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

        $schools = $this->UserDataAccessService->returnAuthUserSchoolsArrays();

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
        $myId = $this->UserDataAccessRepository->getAuthUserId();

        $myAccount = $this->UserDataAccessRepository->getAuthUser();

        // selectボタン用にareaデータを取ってくる
        $areas = $this->UserDataAccessRepository->getAreaArray();

        // ここでチームとポジションを登録
        $this->AllDataSaveService->saveTeamAndPosition($request, $myId);

        // ここでもしユーザーが入力してたら登録
        $this->UserDataSaveService->saveAuthUserDataNameIntroductionAgeArea($request);

        $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

        $schools = $this->UserDataAccessService->returnAuthUserSchoolsArrays();

        return view('myService.profile')->with([
            'areas' => $areas,
            'myAccount' => $myAccount,
            'profile_success' => '入力された項目のプロフィールを登録しました',
            'area_id' => $area_id,
            'schools' => $schools,
        ]);
    }


}
