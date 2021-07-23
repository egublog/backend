<?php

namespace App\packages\UseCase\User\Get;


// use packages\User\Commons\UserModel;
// use App\packages\UseCase\User\Commons\UserModel;

class GetAuthUsersFriendsRequest
{
    private $identify_id;

    /**
     * UserGetListResponse constructor.
     * @param string $identify_id
     */
    public function __construct(string $identify_id)
    {
        $this->identify_id = $identify_id;
    }

    /**
     * @return string
     */
     public function getIdentify_id(): string
     {
         return $this->identify_id;
     }


}
