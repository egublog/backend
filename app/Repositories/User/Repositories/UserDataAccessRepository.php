<?php

namespace App\Repositories\User\Repositories;

use App\Repositories\User\Interfaces\UserDataAccessInterface;
use Illuminate\Support\Facades\Auth;



class UserDataAccessRepository implements UserDataAccessInterface
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
}