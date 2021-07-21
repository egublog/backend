<?php

namespace App\MyClasses;

use App\Team;
// use App\All;
use App\Era;
use Illuminate\Support\Facades\Storage;


class Profile
{

  public function returnSchoolsArrayes($myAccount)
  {
    $elementaryTeam = $myAccount->returnTeamName(1);
    $elementaryPosition = $myAccount->returnPositionId(1);

    $juniorHighTeam = $myAccount->returnTeamName(2);
    $juniorHighPosition = $myAccount->returnPositionId(2);

    $highTeam = $myAccount->returnTeamName(3);
    $highPosition = $myAccount->returnPositionId(3);

    $universityTeam = $myAccount->returnTeamName(4);
    $universityPosition = $myAccount->returnPositionId(4);

    return array(
      array('小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition),
      array('中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition),
      array('高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition),
      array('大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition)
    );
  }




  public function saveTeamAndPosition($request, $myId)
  {
    $schools = array(
      array(1, $request->elementaryTeam, $request->elementaryPosition),
      array(2, $request->juniorHighTeam, $request->juniorHighPosition),
      array(3, $request->highTeam, $request->highPosition),
      array(4, $request->universityTeam, $request->universityPosition)
    );

    foreach ($schools as $school) {
      // まずprofileでユーザーがチーム名を入力したかを年代別に確かめる、入力してたら次の処理をする
      if ($school[1]) {

        $teamAlready = Team::TeamNameEqual($school[1])->first();

        // そのユーザーが入力していたチーム名と全く同じチームがデータベースに登録されていたらそのteam_idを$team_idに代入
        //           されていなかったら新しく今回入力されたチーム名をデータベースに登録してそのteam_idを$team_idに代入
        if ($teamAlready) {
          $team_id = $teamAlready->id;
        } else {
          $team = new Team();
          $team->saveTeam($school[1]);
          $team_id = Team::TeamNameEqual($school[1])->first()->id;
        }
    
        // で年代毎に入力されたポディションidをAllテーブルに保存する   Eraに変更
        $era = Era::myIdEraEqual($myId, $school[0])->first();
        $era->saveTeamIdAndPositionId($team_id, $school[2]);
      } // if ($school[1])

    } // foreach

  }

  public function saveNameIntroductionAgeArea($request, $myAccount)
  {
    // ここでもしユーザーが入力してたら登録
    $columns = array('user_name', 'introduction', 'age', 'area_id');
    foreach ($columns as $column) {
      if ($request->$column) {
        $myAccount->saveColumn($request, $column);
      }
    }
  }




  public function saveImageToDatabaseAndReturnThePath($request)
  {
    $image = $request->file('image');
    $path = Storage::disk('s3')->putFile('test', $image, 'public');
    return $path;
  }






}
