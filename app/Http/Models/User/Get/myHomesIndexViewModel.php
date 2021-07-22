<?php

namespace App\Http\Models\User\Get;

// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;
// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Commons\UserModel;


class MyHomesIndexViewModel
{
    public $user;

    /**
     * UserIndexViewModel constructor.
     * @param UserModel $users
     */
    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }
}