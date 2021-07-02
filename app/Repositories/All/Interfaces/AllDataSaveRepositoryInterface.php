<?php

namespace App\Repositories\All\Interfaces;

interface AllDataSaveRepositoryInterface
{
    public function saveAllFirstData($myId);
    public function  saveAllDataTeamidPositionid($allInstance, $team_id, $position_id);
}