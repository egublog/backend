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
use App\Facades\Area as AreaFacade;

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;
use App\Services\All\Interfaces\AllDataServiceInterface;
// use App\Services\User\Interfaces\UserDataServiceInterface;

use App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use App\Http\Models\Era\Commons\EraViewModelForProfile;

use App\Http\Models\User\Commons\UserViewModel;
use App\Http\Models\User\Get\ProfilesIndexViewModel;




class ProfileController extends Controller
{
    // private $UserDataRepository;
    // private $UserDataService;
    // private $AllDataService;
    // // private $UserDataService;

    // public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService, AllDataServiceInterface $AllDataService)
    // {
    //     $this->UserDataRepository = $UserDataRepository;
    //     $this->UserDataService = $UserDataService;
    //     $this->AllDataService = $AllDataService;
    //     // $this->UserDataService = $UserDataService;
    // }
    private $GetAuthUserUseCase;


    public function __construct(GetAuthUserUseCaseInterface $GetAuthUserUseCase)
    {
        // $this->UserDataRepository = $UserDataRepository;
        $this->GetAuthUserUseCase = $GetAuthUserUseCase;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // selectボタン用にareaデータを取ってくる
        // $areas = $this->UserDataRepository->getAreaArray();

        // $myAccount = $this->UserDataRepository->getAuthUser();

        // $area_id = $this->UserDataRepository->getAuthUserAreaid();

        // $schools = $this->UserDataService->returnAuthUserSchoolsArrays();

        $response = $this->GetAuthUserUseCase->handle();
        // dd($response);
        // $schools = [
        //     ['小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition],
        //     ['中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition],
        //     ['高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition],
        //     ['大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition]
        // ];

        $eraViewModelForProfileArray = [];
        foreach($response->user->eras as $era)
        {
            $eraViewModelForProfileArray[] = new EraViewModelForProfile($era->id, $era->era_id, $era->team_name, $era->position_id);
        }
        // dd($eraViewModelForProfileArray);
        $x = $response->user;

        $userViewModel = new UserViewModel($x->id, $x->name, $x->email, $x->user_name, $x->age, $x->image, $x->introduction, $x->area_id, $x->area_name, $eraViewModelForProfileArray);
        // (int $id, string $name, string $email, ?string $user_name, ?int $age, ?string $image, ?string $introduction, int $area_name, array $eras)
// dd($userViewModel);


        $areas = AreaFacade::getAreaArray();
        // dd($area);

        $viewModel = new ProfilesIndexViewModel($userViewModel, $areas);

        // dd($viewModel);

        // return view('myService.profile')->with([
        //     'areas' => $areas,
        //     'myAccount' => $myAccount,
        //     'area_id' => $area_id,
        //     'schools' => $schools,
        // ]);

        return view('myService.profile', compact('viewModel'));

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
