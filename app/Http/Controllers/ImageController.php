<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Area;
use Illuminate\Support\Facades\Storage;
use App\Facades\Profile;

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;
// use App\Repositories\User\Interfaces\UserDataRepositoryInterface;




class ImageController extends Controller
{
    private $UserDataRepository;
    private $UserDataService;
    // private $UserDataRepository;

    public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService)
    {
        $this->UserDataRepository = $UserDataRepository;
        $this->UserDataService = $UserDataService;
        // $this->UserDataRepository = $UserDataRepository;
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

    public function update(ImageRequest $request, $id)
    { {
            $myAccount = $this->UserDataRepository->getAuthUser();

            // // ↓ ここで画像データをS3に保存(/testにpublicで).  そのS3の中での画像のパスを$pathに保存
            $path = Profile::saveImageToDatabaseAndReturnThePath($request);

            // こっち側からS3の中のそのファイルまでのフルパスをUserテーブルのimageカラムに保存
            $this->UserDataRepository->saveAuthUserImagePathToUsersTable($path);

            // selectボタン用にareaデータを取ってくる
            $areas = $this->UserDataRepository->getAreaArray();

            $area_id = $this->UserDataRepository->getAuthUserAreaid();

            $schools = $this->UserDataService->returnAuthUserSchoolsArrays();

            return view('myService.profile')->with([
                'areas' => $areas,
                'myAccount' => $myAccount,
                'area_id' => $area_id,
                'schools' => $schools,
            ]);
        }
    }

}
