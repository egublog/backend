<?php

namespace App\Services\User\Services;

use App\Services\User\Interfaces\UserDataAccessServiceInterface;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Facades\IdentifyId;





class UserDataAccessService implements UserDataAccessServiceInterface
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


}
