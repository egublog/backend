<?php

namespace App\Repositories\All\Interfaces;

interface AllDataRepositoryInterface
{
    public function getAllFirst($myId);
    public function getAllDataUseridEraidEqual($myId, $era_id);
    public function getAllEqualEraidTeamid($era_id, $team_id);
//  ↓ saveから移動
public function saveAllFirstData($myId);
    public function  saveAllDataTeamidPositionid($allInstance, $team_id, $position_id);
}