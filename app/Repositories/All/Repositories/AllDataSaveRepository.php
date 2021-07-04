<?php

namespace App\Repositories\All\Repositories;

use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;
use App\All;


class AllDataSaveRepository implements AllDataSaveRepositoryInterface
{
 
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

  public function  saveAllDataTeamidPositionid($allInstance, $team_id, $position_id)
  {
    $allInstance->team_id = $team_id;
    $allInstance->position_id = $position_id;
    $allInstance->save();
  }
}
