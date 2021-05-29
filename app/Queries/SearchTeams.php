<?php


namespace App\Queries;

use App\Team;



final class SearchTeams
{
  
  public static function get($team_string)
  {
    return Team::where('team_name', 'like', '%' . $team_string . '%')->pluck('id')->all();
  }
}



