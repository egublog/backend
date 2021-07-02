<?php

namespace App\Services\Talk\Services;

use App\Services\Talk\Interfaces\TalkDataSaveServiceInterface;
use App\Talk_list;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Repositories\Talk_list\Interfaces\TalkListDataAccessRepositoryInterface;
use App\Repositories\Talk\Interfaces\TalkDataAccessRepositoryInterface;
use App\Repositories\Talk\Interfaces\TalkDataSaveRepositoryInterface;






class TalkDataSaveService implements TalkDataSaveServiceInterface
{

  // private $UserDataAccessRepository;
  // private $TalkListDataAccessRepository;
  private $TalkDataAccessRepository;
  private $TalkDataSaveRepository;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, TalkListDataAccessRepositoryInterface $TalkListDataAccessRepository, TalkDataAccessRepositoryInterface $TalkDataAccessRepository, TalkDataSaveRepositoryInterface $TalkDataSaveRepository)
  {
    // $this->UserDataAccessRepository = $UserDataAccessRepository;
    // $this->TalkListDataAccessRepository = $TalkListDataAccessRepository;
    $this->TalkDataAccessRepository = $TalkDataAccessRepository;
    $this->TalkDataSaveRepository = $TalkDataSaveRepository;
  }



  public function saveYetColumnsTrue($myId, $user_id)
  {
    // $talkDatas = Talk::yetColumnsFalse($myId, $user_id)->get();
    $talkDatas = $this->TalkDataAccessRepository->getOurTalkYetColumnFalse($myId, $user_id);

    if ($talkDatas) {
      // TalkList::changeYetColumnsTrue($talkDatas);
      foreach ($talkDatas as $talkData) {
        // $talkData->yet = true;
        // $talkData->save();
        $this->TalkDataSaveRepository->saveYetColumnTure($talkData);
      }
  }

  }



}
