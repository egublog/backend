<?php

namespace App\packages\UseCase\User\Get;


// use packages\User\Commons\UserModel;
// use App\packages\UseCase\User\Commons\UserModel;

class GetUserIdRequest
{
    private $user_id;

    /**
     * UserGetListResponse constructor.
     * @param int $user_id
     */
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
     public function getUser_id(): int
     {
         return $this->user_id;
     }


}
