<?php

namespace App\Http\Models\User\Get;

// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;
// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Commons\UserModel;


class FriendsIndexViewModel
{
    /**
       * @var array
       */
       public $accounts;
      
       /**
        * @var UserModel
        */
       public $myAccount;

       /**
        * @var string
        */
       public $identify_id;

    /**
     * UserIndexViewModel constructor.
     * @param array $accounts
     * @param UserModel $myAccount
     * @param string $identify_id
     */
    public function __construct(array $accounts, UserModel $myAccount, string $identify_id)
    {
        $this->accounts = $accounts;
        $this->myAccount = $myAccount;
        $this->identify_id = $identify_id;
    }
}