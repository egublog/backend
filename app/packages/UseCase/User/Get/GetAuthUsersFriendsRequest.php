<?php

namespace App\packages\UseCase\User\Get;


// use packages\User\Commons\UserModel;
// use App\packages\UseCase\User\Commons\UserModel;

class GetAuthUsersFriendsRequest
{
    private $identify_id;

    /**
     * UserGetListResponse constructor.
     * @param int $user
     */
    public function __construct(int $identify_id)
    {
        $this->identify_id = $identify_id;
    }

    /**
     * @return int
     */
     public function getIdentify_id(): int
     {
         return $this->identify_id;
     }


}
