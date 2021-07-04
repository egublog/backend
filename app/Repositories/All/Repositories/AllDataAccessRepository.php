<?php

namespace App\Repositories\All\Repositories;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\All;




class AllDataAccessRepository implements AllDataAccessRepositoryInterface
{

  public function getAllFirst($myId)
  {
    return All::where('user_id', $myId)->where('era_id', 1)->first();
  }

  public function getAllDataUseridEraidEqual($myId, $era_id)
  {
    return All::where('user_id', $myId)->where('era_id', $era_id)->first();
  }

  public function getAllEqualEraidTeamid($era_id, $team_id)
  {
    return All::where('era_id', $era_id)->where('team_id', $team_id)->with('user')->get();
  }

}
