<?php

namespace App\Repositories\Team\Repositories;

use App\Repositories\Team\Interfaces\TeamDataRepositoryInterface;
use App\Team;




class TeamDataRepository implements TeamDataRepositoryInterface
{

    public function getTeamNameEqual($team_string)
    {
      return Team::where('team_name', $team_string)->first();
    }
    
    public function getTeamNameEqualTeamid($team_string)
    {
      return Team::where('team_name', $team_string)->first()->id;
    }
    
    public function getTeamidsLikeTeamName($team_string)
    {
      return Team::where('team_name', 'like', '%' . $team_string . '%')->pluck('id')->all();
    }

//  ↓ saveから移動
    public function saveTeamName($team_string)
    {
      $team = new Team();
      $team->team_name = $team_string;
      $team->save();
    }
}