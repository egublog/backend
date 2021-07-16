<?php

namespace App\Http\Models\User\Get;

// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;
use App\Http\Models\User\Commons\UserViewModel;

class MyHomesIndexViewModel
{
    public $user;

    /**
     * UserIndexViewModel constructor.
     * @param UserViewModel $users
     */
    public function __construct(UserViewModel $user)
    {
        $this->user = $user;
    }
}