<?php

namespace App\MyClasses;

// use App\All;
use App\Era;


class SearchAllses
{
  public function getAllArray($era_id, $team_ids)
  {
    $searchAlls = collect([]);
    
    // 引数で渡ってきた$era_idと$team_idsからそれにマッチしたAllコレクションを一つのコレクションに合体させてreturnする
    if ($team_ids) {
      foreach ($team_ids as $team_id) {
        $searchAlls = $searchAlls->merge(Era::getSearchAll($era_id, $team_id));
      }
    }
    return $searchAlls;
  }
}
