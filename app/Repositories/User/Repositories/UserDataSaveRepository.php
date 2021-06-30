<?php

namespace App\Repositories\User\Repositories;

use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;



class UserDataSaveRepository implements UserDataSaveRepositoryInterface
{
  // protected $Auth;
  private $UserDataAccess;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccess)
  {
    //    $this->Auth = $Auth;
    $this->UserDataAccess = $UserDataAccess;
  }


  public function saveAuthUserAreaid($area_id)
  {
    $this->UserDataAccess->getAuthUser()->area_id = $area_id;
    $this->UserDataAccess->getAuthUser()->save();
  }
}
