<?php

namespace App\Repositories\User\Repositories;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use Illuminate\Support\Facades\Auth;



class UserDataAccessRepository implements UserDataAccessRepositoryInterface
{
    // protected $Auth;


    public function __construct()
    {
    //    $this->Auth = $Auth;
    }

    public function getAuthUser()
    {
        return Auth::user();
    }

    public function getAuthUserId()
    {
        return Auth::id();
    }

    public function getAuthUserAreaid()
    {
        return $this->getAuthUser()->area_id;
    }

    public function getFriendsFollow($user)
    {
        return $user->getFollow();
    }

    public function getFriendsFollower($user)
    {
        return $user->getFollower();
    }
}