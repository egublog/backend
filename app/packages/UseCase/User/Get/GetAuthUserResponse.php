<?php

namespace App\packages\UseCase\User\Get;


use packages\User\Commons\UserModel;

class GetAuthUserResponse
{
    public $user;

    /**
     * UserGetListResponse constructor.
     * @param UserModel $user
     */
    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }
}
