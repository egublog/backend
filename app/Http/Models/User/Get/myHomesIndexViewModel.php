<?php

namespace App\Http\Models\User\Get;

// use App\Http\Models\User\Commons\UserViewModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;

class MyHomesIndexViewModel
{
    public $user;

    /**
     * UserIndexViewModel constructor.
     * @param GetAuthUserResponse $users
     */
    public function __construct(GetAuthUserResponse $user)
    {
        $this->user = $user;
    }
}