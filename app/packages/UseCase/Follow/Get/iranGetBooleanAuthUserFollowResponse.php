<?php

namespace App\packages\UseCase\Follow\Get;


// use packages\User\Commons\UserModel;
// use App\packages\UseCase\User\Commons\UserModel;

class GetBooleanAuthUserFollowResponse
{
    public $follow_check;

    /**
     * GetBooleanAuthUserFollowResponse constructor.
     * @param bool $follow_check
     */
    public function __construct(bool $follow_check)
    {
        $this->follow_check = $follow_check;
    }
}
