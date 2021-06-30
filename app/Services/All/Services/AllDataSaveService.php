<?php

namespace App\Services\All\Services;

use App\Services\All\Interfaces\AllDataSaveServiceInterface;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;





class AllDataSaveService implements AllDataSaveServiceInterface
{
  // protected $All;
  private $AllDataAccessRepository;
  private $AllDataSaveRepository;



  public function __construct(AllDataAccessRepositoryInterface $AllDataAccessRepository, AllDataSaveRepositoryInterface $AllDataSaveRepository)
  {
    //    $this->Auth = $Auth;
    $this->AllDataAccessRepository = $AllDataAccessRepository;
    $this->AllDataSaveRepository = $AllDataSaveRepository;
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
}
