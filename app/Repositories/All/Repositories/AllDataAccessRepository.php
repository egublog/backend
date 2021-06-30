<?php

namespace App\Repositories\All\Repositories;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\All;




class AllDataAccessRepository implements AllDataAccessRepositoryInterface
{
    // protected $All;


    public function __construct()
    {
    //    $this->Auth = $Auth;
    }

    public function getAllFirst($myId)
    {
        return All::where('user_id', $myId)->where('era_id', 1)->first();
    }


}