<?php

namespace App\Services\All\Services;

use App\Services\All\Interfaces\AllDataAccessServiceInterface;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;
use App\Repositories\Team\Interfaces\TeamDataAccessRepositoryInterface;
use App\Repositories\Team\Interfaces\TeamDataSaveRepositoryInterface;






class AllDataAccessService implements AllDataAccessServiceInterface
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
}
