<?php

namespace App\packages\UseCase\User\Get;


// use packages\User\Commons\UserModel;
// use App\packages\UseCase\User\Commons\UserModel;

class GetAuthUsersFriendsResponse
{
    public $accounts;

    /**
     * UserGetListResponse constructor.
     * @param array $accounts
     */
    public function __construct(array $accounts)
    {
        $this->accounts = $accounts;
    }
}
