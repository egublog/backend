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
    if ($this->UserDataAccessRepository->getAuthUserAreaid() === null) {
      $this->UserDataSaveRepository->saveAuthUserAreaid(50);
    }
  }

  public function saveAuthUserDataNameIntroductionAgeArea($request)
  {
    $columns = array('user_name', 'introduction', 'age', 'area_id');
    foreach ($columns as $column_name) {
      if ($request->$column_name) {
        // $myAccount->saveColumn($request, $column);
        $this->UserDataSaveRepository->saveAuthUserDataColumn($request, $column_name);
      }
    }
  }

}
