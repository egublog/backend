<?php

namespace App\Repositories\All\Repositories;

use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;
use App\All;




class AllDataSaveRepository implements AllDataSaveRepositoryInterface
{
  // protected $All;


  public function __construct()
  {
    //    $this->Auth = $Auth;
  }

  public function saveAllFirstData($myId)
  {
    for ($i = 1; $i < 5; $i++) {
      $all = new All();
      $all->user_id = $myId;
      $all->team_id = 1;
      $all->position_id = 1;
      $all->era_id = $i;
      $all->save();
    }
  }
}
