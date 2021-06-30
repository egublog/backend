<?php

namespace App\Services\All\Services;

use App\Services\All\Interfaces\AllDataSaveServiceInterface;

use App\Repositories\All\Interfaces\AllDataAccessRepositoryInterface;
use App\Repositories\All\Interfaces\AllDataSaveRepositoryInterface;





class AllDataSaveService implements AllDataSaveServiceInterface
{
  // protected $All;
  private $AllDataAccess;
  private $AllDataSave;



  public function __construct(AllDataAccessRepositoryInterface $AllDataAccess, AllDataSaveRepositoryInterface $AllDataSave)
  {
    //    $this->Auth = $Auth;
    $this->AllDataAccess = $AllDataAccess;
    $this->AllDataSave = $AllDataSave;
  }

  // private function getAllFirst()
  // {
  //   $allEra = $this->AllDataAccess->getAllFirst($myId);
  // }

  public function saveAllFirstData($myId)
  {
    $allEra = $this->AllDataAccess->getAllFirst($myId);
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
        $this->AllDataSave->saveAllFirstData($myId);
    }
  }
}
