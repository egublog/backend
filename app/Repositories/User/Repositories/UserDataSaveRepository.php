<?php

namespace App\Repositories\User\Repositories;

use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use Illuminate\Support\Facades\Storage;



class UserDataSaveRepository implements UserDataSaveRepositoryInterface
{
  // protected $Auth;
  private $UserDataAccessRepository;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository)
  {
    //    $this->Auth = $Auth;
    $this->UserDataAccessRepository = $UserDataAccessRepository;
  }


  public function saveAuthUserAreaid($area_id)
  {
    $myAccount = $this->UserDataAccessRepository->getAuthUser();
    $myAccount->area_id = $area_id;
    $myAccount->save();
  }

  public function saveAuthUserDataColumn($request, $column_name)
  {
    $myAccount = $this->UserDataAccessRepository->getAuthUser();
    $myAccount->$column_name = $request->$column_name;
    $myAccount->save();
  }

  public function saveAuthUserImagePathToUsersTable($path)
  {
    $myAccount = $this->UserDataAccessRepository->getAuthUser();
    $myAccount->image = Storage::disk('s3')->url($path);
    $myAccount->save();
  }
}
