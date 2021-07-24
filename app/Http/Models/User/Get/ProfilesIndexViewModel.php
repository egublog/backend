<?php

namespace App\Http\Models\User\Get;

// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;
// use App\Http\Models\User\Commons\UserViewModel;
// use App\packages\UseCase\User\Commons\UserModel;
use App\Http\Models\User\Commons\UserViewModel;



class ProfilesIndexViewModel
{
  /**
  * @var UserViewModel
  */
  public $myAccount;

  /**
  * @var array
  */
  public $areas;

  /**
   * FriendsShowViewModel constructor.
   * @param UserViewModel $user
   * @param array $areas
   */
  public function __construct(UserViewModel $user, array $areas)
  {
      $this->myAccount = $user;
      $this->areas = $areas;
  }
}