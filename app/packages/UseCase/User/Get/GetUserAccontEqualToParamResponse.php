<?php

namespace App\packages\UseCase\User\Get;


// use packages\User\Commons\UserModel;
use App\packages\UseCase\User\Commons\UserModel;

class GetUserAccontEqualToParamResponse
{
    public $user;

    /**
     * GetBooleanAuthUserFollowResponse constructor.
     * @param UserModel $user
     */
    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }
}
