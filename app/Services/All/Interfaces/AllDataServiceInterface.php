<?php

namespace App\Services\All\Interfaces;

interface AllDataServiceInterface
{
   public function getAllCollectionEqualEraidTeamids($era_id, $team_ids);
//  ↓ saveから移動
public function saveAllFirstData($myId);
    public function saveTeamAndPosition($request, $myId);
}