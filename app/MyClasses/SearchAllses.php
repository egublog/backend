<?php

namespace App\MyClasses;

use App\All;


class SearchAllses
{
  public function getAllArray($era_id, $team_ids)
  {

// dd($era_id);
    // dd($team_ids);

    // $searchAllses = [];
    $searchAlls = collect([]);
    if ($team_ids) {

      // dd($collection);

      // $searchAllses = array();
      foreach ($team_ids as $team_id) {
        // $searchAllses[] = All::where('era_id', $request->era_id)->where('team_id', $team_id)->get();
        $searchAlls = $searchAlls->merge(All::getSearchAll($era_id, $team_id));
      }
      // ↑ このやり方だとチームめいはあるけど、指定された年代に登録がない時に空のコレクションの配列が返ってきてしまう。
      // だからコレクションを合体させて一つのコレクションにしたい。
    }

    // dd($searchAllses);
    //  else {
      // $searchAllses = [];
    // }
    return $searchAlls;
  }
}
