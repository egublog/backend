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

  public function saveOurTalkData($message, $myId, $user_id)
  {
    if ($message != "") {
      // $talkData = new Talk();
      // $talkData->saveNewTalk($message, $myId, $user_id);
      $this->TalkDataSaveRepository->saveOurTalkData($message, $myId, $user_id);
  }
  }

  public function updateOurTalkCheckColumn($myId, $user_id)
  {
    // ↓ ここからの処理は非同期でもその日,初めてのトークだったらその日の日付を表示すると言う機能の為の下処理

    // ここでは自分と相手のトークデータの最新の一個前のレコードを取ってくる
    // $talkDataOneBefore = Talk::TalkDataOneBefore($myId, $user_id)->first();
    $talkDataOneBefore = $this->TalkDataAccessRepository->getOurTalkDataOneBeforeFirst($myId, $user_id);

    // first()で取ってくると何もなかった時にnullが入ってくる。
    // get()で取ってくると何もなかった時に collectionの{#items: []}が返ってくるからその違いに注意

    // ここでは自分と相手のトークデータの最新のレコードを取ってくる
    // $talkDataNow = Talk::TalkDataNow($myId, $user_id)->first();
    $talkDataNow =  $this->TalkDataAccessRepository->getOurTalkDataLatest($myId, $user_id);


    // $talkDataOneBeforeと$talkDataNowの日付を比較して同じだったらtalkCheckカラム(boolean型)にfalse違ったらtrueをいれる($talkDataOneBeforeが存在しなかった場合はtrueをいれる）
    // $talkDataNow->saveTalkCheckColumn($talkDataOneBefore);
    if ($talkDataOneBefore == null) {
      // $this->talkCheck = true;
      // $this->save();
      $this->TalkDataSaveRepository->updateOurTalkCheckColumn($talkDataNow);
  } else {
      if ($talkDataOneBefore->created_at->format('n/j') != $talkDataNow->created_at->format('n/j')) {
          // $this->talkCheck = true;
          // $this->save();
      $this->TalkDataSaveRepository->updateOurTalkCheckColumn($talkDataNow);

      }
  }
    

  }




}
