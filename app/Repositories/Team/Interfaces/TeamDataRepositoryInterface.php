<?php

namespace App\Repositories\Team\Interfaces;

interface TeamDataRepositoryInterface
{
    public function getTeamNameEqual($team_string);
    public function getTeamNameEqualTeamid($team_string);
    public function getTeamidsLikeTeamName($team_string);
//  ↓ saveから移動
public function saveTeamName($team_string);
}