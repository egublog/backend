<?php

namespace App\Repositories\Team\Interfaces;

interface TeamDataAccessRepositoryInterface
{
    public function getTeamNameEqual($team_string);
    public function getTeamNameEqualTeamid($team_string);
}