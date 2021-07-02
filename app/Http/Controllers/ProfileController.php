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
        // selectボタン用にareaテーブルから全てを取ってくる (areas)
        // $areas = $this->areas();
        $areas = $this->UserDataAccessRepository->getAreaArray();

        // $myAccount = Auth::user();
        $myAccount = $this->UserDataAccessRepository->getAuthUser();

        // $area_id = $myAccount->area_id;
        $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

        // $schools = Profile::returnSchoolsArrayes($myAccount);
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
        //
        {
            // $areas = $this->areas();
            $areas = $this->UserDataAccessRepository->getAreaArray();

            // $myAccount = Auth::user();
            $myAccount = $this->UserDataAccessRepository->getAuthUser();

            // $area_id = $myAccount->area_id;
            $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

            // $schools = Profile::returnSchoolsArrayes($myAccount);
            $schools = $this->UserDataAccessService->returnAuthUserSchoolsArrays();


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
            // $myId = Auth::id();
            $myId = $this->UserDataAccessRepository->getAuthUserId();

            // $myAccount = Auth::user();
            $myAccount = $this->UserDataAccessRepository->getAuthUser();


            // $areas = $this->areas();
            $areas = $this->UserDataAccessRepository->getAreaArray();

            // ここでチームとポジションを登録
            // Profile::saveTeamAndPosition($request, $myId);
            $this->AllDataSaveService->saveTeamAndPosition($request, $myId);

            // ここでもしユーザーが入力してたら登録
            // Profile::saveNameIntroductionAgeArea($request, $myAccount);
            $this->UserDataSaveService->saveAuthUserDataNameIntroductionAgeArea($request);

            // $area_id = $myAccount->area_id;
            $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

            // $schools = Profile::returnSchoolsArrayes($myAccount);
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


    // private function areas()
    // {
    //     $prefs = [
    //         '1' => '北海道',
    //         '2' => '青森県',
    //         '3' => '岩手県',
    //         '4' => '宮城県',
    //         '5' => '秋田県',
    //         '6' => '山形県',
    //         '7' => '福島県',
    //         '8' => '茨城県',
    //         '9' => '栃木県',
    //         '10' => '群馬県',
    //         '11' => '埼玉県',
    //         '12' => '千葉県',
    //         '13' => '東京都',
    //         '14' => '神奈川県',
    //         '15' => '新潟県',
    //         '16' => '富山県',
    //         '17' => '石川県',
    //         '18' => '福井県',
    //         '19' => '山梨県',
    //         '20' => '長野県',
    //         '21' => '岐阜県',
    //         '22' => '静岡県',
    //         '23' => '愛知県',
    //         '24' => '三重県',
    //         '25' => '滋賀県',
    //         '26' => '京都府',
    //         '27' => '大阪府',
    //         '28' => '兵庫県',
    //         '29' => '奈良県',
    //         '30' => '和歌山県',
    //         '31' => '鳥取県',
    //         '32' => '島根県',
    //         '33' => '岡山県',
    //         '34' => '広島県',
    //         '35' => '山口県',
    //         '36' => '徳島県',
    //         '37' => '香川県',
    //         '38' => '愛媛県',
    //         '39' => '高知県',
    //         '40' => '福岡県',
    //         '41' => '佐賀県',
    //         '42' => '長崎県',
    //         '43' => '熊本県',
    //         '44' => '大分県',
    //         '45' => '宮崎県',
    //         '46' => '鹿児島県',
    //         '47' => '沖縄県',
    //         '48' => '海外',
    //         '49' => 'その他',
    //         '50' => '未設定です',
    //     ];

    //     return $prefs;
    // }
}
