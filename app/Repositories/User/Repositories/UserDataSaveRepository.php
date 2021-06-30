<?php

namespace App\Repositories\User\Repositories;

use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;



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
    $this->UserDataAccessRepository->getAuthUser()->area_id = $area_id;
    $this->UserDataAccessRepository->getAuthUser()->save();
  }
}
