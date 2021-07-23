<?php

namespace App\Http\Models\User\Get;

// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;
// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Commons\UserModel;


class FriendsShowViewModel
{
  /**
  * @var UserModel
  */
  public $hisAccount;

  /**
  * @var string
  */
  public $identify_id;

  /**
   * FriendsShowViewModel constructor.
   * @param UserModel $user
   * @param string $identify_id
   */
  public function __construct(UserModel $user, string $identify_id)
  {
      $this->hisAccount = $user;
      $this->identify_id = $identify_id;
  }
}