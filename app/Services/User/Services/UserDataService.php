<?php

namespace App\Services\User\Services;

use App\Services\User\Interfaces\UserDataServiceInterface;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Facades\IdentifyId;
//  ↓ saveから移動
use App\Services\User\Interfaces\UserDataSaveServiceInterface;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Repositories\User\Interfaces\UserDataSaveRepositoryInterface;






class UserDataService implements UserDataServiceInterface
{
  private $UserDataAccessRepository;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository)
  {
    $this->UserDataAccessRepository = $UserDataAccessRepository;
  }


  public function getAuthUserFriends($identify_id)
  {
    $user = $this->UserDataAccessRepository->getAuthUser();
    if (IdentifyId::friendFollow($identify_id)) {
      // 自分がフォローしている人を取得
      return  $this->UserDataAccessRepository->getFriendsFollow($user);
    } elseif (IdentifyId::friendFollower($identify_id)) {
      // 自分をフォローしている人を取得
      return $this->UserDataAccessRepository->getFriendsFollower($user);
    }
  }


  public function AuthUserFollowCheck($his_id)
  {
    $user = $this->UserDataAccessRepository->getAuthUser();
    return $this->UserDataAccessRepository->getFollowHimFirst($user, $his_id) === null ? false : true;
  }

  public function returnAuthUserSchoolsArrays()
  {
    $elementaryTeam = $this->UserDataAccessRepository->getAuthUserTeamName(1);
    $elementaryPosition = $this->UserDataAccessRepository->getAuthUserPositionId(1);

    $juniorHighTeam = $this->UserDataAccessRepository->getAuthUserTeamName(2);
    $juniorHighPosition = $this->UserDataAccessRepository->getAuthUserPositionId(2);

    $highTeam = $this->UserDataAccessRepository->getAuthUserTeamName(3);
    $highPosition = $this->UserDataAccessRepository->getAuthUserPositionId(3);

    $universityTeam = $this->UserDataAccessRepository->getAuthUserTeamName(4);
    $universityPosition = $this->UserDataAccessRepository->getAuthUserPositionId(4);

    return array(
      array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
      array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
      array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
      array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
    );
  }

//  ↓ saveから移動
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
