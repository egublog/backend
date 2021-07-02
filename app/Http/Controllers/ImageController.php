<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Area;
use Illuminate\Support\Facades\Storage;
use App\Facades\Profile;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;
use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;




class ImageController extends Controller
{

    private $UserDataAccessRepository;
    private $UserDataAccessService;
    private $UserDataSaveRepository;
    

    public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataAccessServiceInterface $UserDataAccessService, UserDataSaveRepositoryInterface $UserDataSaveRepository)
    {
        $this->UserDataAccessRepository = $UserDataAccessRepository;
        $this->UserDataAccessService = $UserDataAccessService;
        $this->UserDataSaveRepository = $UserDataSaveRepository;
        
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

    public function update(ImageRequest $request, $id)
    { {
            // $myAccount = Auth::user();
            $myAccount = $this->UserDataAccessRepository->getAuthUser();


            // // ↓ ここで画像データをS3に保存(/testにpublicで).  そのS3の中での画像のパスを$pathに保存
            $path = Profile::saveImageToDatabaseAndReturnThePath($request);

            // こっち側からS3の中のそのファイルまでのフルパスをUserテーブルのimageカラムに保存
            // $myAccount->saveImagePathToUsersTable($path);
            $this->UserDataSaveRepository->saveAuthUserImagePathToUsersTable($path);

            // $areas = $this->areas();
            $areas = $this->UserDataAccessRepository->getAreaArray();


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
