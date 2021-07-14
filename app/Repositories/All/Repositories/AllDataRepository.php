<?php

namespace App\Repositories\All\Repositories;

use App\Repositories\All\Interfaces\AllDataRepositoryInterface;
use App\All;




class AllDataRepository implements AllDataRepositoryInterface
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
    // ↑ ここでUserをとって来ちゃえばいい Allテーブルのuser_idを集めてuser_ids[]の配列にして、その配列からUserインスタンスのコレクションを作ってしまう！！
    //      でそのUserインスタンスを集める時にwith(alls.team)でとってくる。
  }
//  ↓ saveから移動

public function saveAllFirstData($myId)
{
  for ($i = 1; $i < 5; $i++) {
    $all = new All();
    $all->user_id = $myId;
    $all->team_id = 1;
    $all->position_id = 1;
    $all->era_id = $i;
    $all->save();
  }
}

public function  saveAllDataTeamidPositionid($allInstance, $team_id, $position_id)
{
  $allInstance->team_id = $team_id;
  $allInstance->position_id = $position_id;
  $allInstance->save();
}

}
