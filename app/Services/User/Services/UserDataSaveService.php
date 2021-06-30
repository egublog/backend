<?php

namespace App\Services\User\Services;

use App\Services\User\Interfaces\UserDataSaveServiceInterface;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;





class UserDataSaveService implements UserDataSaveServiceInterface
{
  private $UserDataAccess;
  private $UserDataSave;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccess, UserDataSaveRepositoryInterface $UserDataSave)
  {
    $this->UserDataAccess = $UserDataAccess;
    $this->UserDataSave = $UserDataSave;
  }

  public function saveAuthUserFirstAreaid()
  {
    if($this->UserDataAccess->getAuthUserAreaid() === null) {
      $this->UserDataSave->saveAuthUserAreaid(50);
  }
  }
}
