<?php

namespace App\Repositories\Team\Repositories;

use App\Repositories\Team\Interfaces\TeamDataSaveRepositoryInterface;
use App\Team;




class TeamDataSaveRepository implements TeamDataSaveRepositoryInterface
{



  public function __construct()
  {
  }

  public function saveTeamName($team_string)
  {
    $team = new Team();
    $team->team_name = $team_string;
    $team->save();
  }
}
