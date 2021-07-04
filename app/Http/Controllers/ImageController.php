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

    public function update(ImageRequest $request, $id)
    { {
            $myAccount = $this->UserDataAccessRepository->getAuthUser();

            // // ↓ ここで画像データをS3に保存(/testにpublicで).  そのS3の中での画像のパスを$pathに保存
            $path = Profile::saveImageToDatabaseAndReturnThePath($request);

            // こっち側からS3の中のそのファイルまでのフルパスをUserテーブルのimageカラムに保存
            $this->UserDataSaveRepository->saveAuthUserImagePathToUsersTable($path);

            // selectボタン用にareaデータを取ってくる
            $areas = $this->UserDataAccessRepository->getAreaArray();

            $area_id = $this->UserDataAccessRepository->getAuthUserAreaid();

            $schools = $this->UserDataAccessService->returnAuthUserSchoolsArrays();

            return view('myService.profile')->with([
                'areas' => $areas,
                'myAccount' => $myAccount,
                'area_id' => $area_id,
                'schools' => $schools,
            ]);
        }
    }

}
