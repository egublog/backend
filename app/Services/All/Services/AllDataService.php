<?php

namespace App\Services\All\Services;

use App\Services\All\Interfaces\AllDataServiceInterface;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;
use App\Repositories\Team\Interfaces\TeamDataAccessRepositoryInterface;
use App\Repositories\Team\Interfaces\TeamDataSaveRepositoryInterface;
//  ↓ saveから移動

use App\Services\All\Interfaces\AllDataSaveServiceInterface;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;
use App\Repositories\Team\Interfaces\TeamDataAccessRepositoryInterface;
use App\Repositories\Team\Interfaces\TeamDataSaveRepositoryInterface;







class AllDataService implements AllDataServiceInterface
{
  // protected $All;
  private $AllDataAccessRepository;
  // private $AllDataSaveRepository;
  // private $TeamDataAccessRepository;
  // private $TeamDataSaveRepository;



  public function __construct(AllDataAccessRepositoryInterface $AllDataAccessRepository, AllDataSaveRepositoryInterface $AllDataSaveRepository, TeamDataAccessRepositoryInterface $TeamDataAccessRepository, TeamDataSaveRepositoryInterface $TeamDataSaveRepository)
  {
    //    $this->Auth = $Auth;
    $this->AllDataAccessRepository = $AllDataAccessRepository;
    // $this->AllDataSaveRepository = $AllDataSaveRepository;
    // $this->TeamDataAccessRepository = $TeamDataAccessRepository;
    // $this->TeamDataSaveRepository = $TeamDataSaveRepository;
  }


  public function getAllCollectionEqualEraidTeamids($era_id, $team_ids)
  {
    $searchAlls = collect([]);

    // 引数で渡ってきた$era_idと$team_idsからそれにマッチしたAllコレクションを一つのコレクションに合体させてreturnする
    if ($team_ids) {
      foreach ($team_ids as $team_id) {
        // $searchAlls = $searchAlls->merge(All::getSearchAll($era_id, $team_id));
        $searchAlls = $searchAlls->merge($this->AllDataAccessRepository->getAllEqualEraidTeamid($era_id, $team_id));
      }
    }
    return $searchAlls;
  }
//  ↓ saveから移動
private $AllDataAccessRepository;
  private $AllDataSaveRepository;
  private $TeamDataAccessRepository;
  private $TeamDataSaveRepository;



  public function __construct(AllDataAccessRepositoryInterface $AllDataAccessRepository, AllDataSaveRepositoryInterface $AllDataSaveRepository, TeamDataAccessRepositoryInterface $TeamDataAccessRepository, TeamDataSaveRepositoryInterface $TeamDataSaveRepository)
  {
    //    $this->Auth = $Auth;
    $this->AllDataAccessRepository = $AllDataAccessRepository;
    $this->AllDataSaveRepository = $AllDataSaveRepository;
    $this->TeamDataAccessRepository = $TeamDataAccessRepository;
    $this->TeamDataSaveRepository = $TeamDataSaveRepository;
  }

  // private function getAllFirst()
  // {
  //   $allEra = $this->AllDataAccess->getAllFirst($myId);
  // }

  public function saveAllFirstData($myId)
  {
    $allEra = $this->AllDataAccessRepository->getAllFirst($myId);
    if ($allEra === null) {
      // dd($allEra);
      // for ($i = 1; $i < 5; $i++) {
      //   $all = new All();
      //   $all->user_id = $myId;
      //   $all->team_id = 1;
      //   $all->position_id = 1;
      //   $all->era_id = $i;
      //   $all->save();
      // }
        $this->AllDataSaveRepository->saveAllFirstData($myId);
    }
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

        // $teamAlready = Team::TeamNameEqual($school[1])->first();
        $teamAlready = $this->TeamDataAccessRepository->getTeamNameEqual($school[1]);

        // そのユーザーが入力していたチーム名と全く同じチームがデータベースに登録されていたらそのteam_idを$team_idに代入
        //           されていなかったら新しく今回入力されたチーム名をデータベースに登録してそのteam_idを$team_idに代入
        if ($teamAlready) {
          // $team_id = $teamAlready->id;
          $team_id = $this->TeamDataAccessRepository->getTeamNameEqualTeamid($school[1]);
        } else {
          // $team = new Team();
          // $team->saveTeam($school[1]);
          $this->TeamDataSaveRepository->saveTeamName($school[1]);

          // $team_id = Team::TeamNameEqual($school[1])->first()->id;
          $team_id = $this->TeamDataAccessRepository->getTeamNameEqualTeamid($school[1]);
        }
    
        // で年代毎に入力されたポディションidをAllテーブルに保存する
        // $all = All::myIdEraEqual($myId, $school[0])->first();
        // $all->saveTeamIdAndPositionId($team_id, $school[2]);

        $allInstance = $this->AllDataAccessRepository->getAllDataUseridEraidEqual($myId, $school[0]);
        $this->AllDataSaveRepository->saveAllDataTeamidPositionid($allInstance, $team_id, $school[2]);
      } // if ($school[1])

    } // foreach
  }



}
