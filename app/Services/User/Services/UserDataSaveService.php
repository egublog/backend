<?php

namespace App\Services\User\Services;

use App\Services\User\Interfaces\UserDataSaveServiceInterface;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;





class UserDataSaveService implements UserDataSaveServiceInterface
{
  private $UserDataAccessRepository;
  private $UserDataSaveRepository;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataSaveRepositoryInterface $UserDataSaveRepository)
  {
    $this->UserDataAccessRepository = $UserDataAccessRepository;
    $this->UserDataSaveRepository = $UserDataSaveRepository;
  }

  public function saveAuthUserFirstAreaid()
  {
    if($this->UserDataAccessRepository->getAuthUserAreaid() === null) {
      $this->UserDataSaveRepository->saveAuthUserAreaid(50);
  }
  }
}
