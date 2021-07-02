<?php

namespace App\Repositories\Team\Repositories;

use App\Repositories\Team\Interfaces\TeamDataAccessRepositoryInterface;
use App\Team;




class TeamDataAccessRepository implements TeamDataAccessRepositoryInterface
{



    public function __construct()
    {
  
    }

    public function getTeamNameEqual($team_string)
    {
      return Team::where('team_name', $team_string)->first();
    }
    
    public function getTeamNameEqualTeamid($team_string)
    {
      return Team::where('team_name', $team_string)->first()->id;
    }
    


}