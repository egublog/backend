<?php

namespace App\Services\Talk\Services;

use App\Services\Talk\Interfaces\TalkDataServiceInterface;
use App\Talk_list;

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
// use App\Repositories\Talk_list\Interfaces\TalkListDataRepositoryInterface;
use App\Repositories\Talk\Interfaces\TalkDataRepositoryInterface;
// use App\Repositories\Talk\Interfaces\TalkDataRepositoryInterface;
//  ↓ saveから移動

// use App\Services\Talk\Interfaces\TalkDataSaveServiceInterface;
// use App\Talk_list;

// use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
// use App\Repositories\Talk_list\Interfaces\TalkListDataAccessRepositoryInterface;
// use App\Repositories\Talk\Interfaces\TalkDataAccessRepositoryInterface;
// use App\Repositories\Talk\Interfaces\TalkDataSaveRepositoryInterface;







class TalkDataService implements TalkDataServiceInterface
{

  //  ↓ saveから移動


  // private $UserDataAccessRepository;
  // private $TalkListDataAccessRepository;
  private $TalkDataRepository;
  // private $TalkDataSaveRepository;


  public function __construct(TalkDataRepositoryInterface $TalkDataRepository)
  {
    // $this->UserDataAccessRepository = $UserDataAccessRepository;
    // $this->TalkListDataAccessRepository = $TalkListDataAccessRepository;
    $this->TalkDataRepository = $TalkDataRepository;
    // $this->TalkDataSaveRepository = $TalkDataSaveRepository;
  }



  public function saveYetColumnsTrue($myId, $user_id)
  {
    // $talkDatas = Talk::yetColumnsFalse($myId, $user_id)->get();
    $talkDatas = $this->TalkDataRepository->getOurTalkYetColumnFalse($myId, $user_id);
    // ↑  空のCollectionかもしれない
    // return Talk::where('from', $user_id)->where('to', $myId)->where('yet', false)->get();


    if ($talkDatas) {
      // TalkList::changeYetColumnsTrue($talkDatas);
      foreach ($talkDatas as $talkData) {
        // $talkData->yet = true;
        // $talkData->save();
        $this->TalkDataRepository->saveYetColumnTure($talkData);
        // ↑ こいう保存処理も全部try catchで囲んで（トランザクション？）例外処理を書く！
      }
    }
  }

  public function saveOurTalkData($message, $myId, $user_id)
  {
    if ($message != "") {
      // $talkData = new Talk();
      // $talkData->saveNewTalk($message, $myId, $user_id);
      $this->TalkDataRepository->saveOurTalkData($message, $myId, $user_id);
    }
  }

  public function updateOurTalkCheckColumn($myId, $user_id)
  {
    // ↓ ここからの処理は非同期でもその日,初めてのトークだったらその日の日付を表示すると言う機能の為の下処理

    // ここでは自分と相手のトークデータの最新の一個前のレコードを取ってくる
    // $talkDataOneBefore = Talk::TalkDataOneBefore($myId, $user_id)->first();
    $talkDataOneBefore = $this->TalkDataRepository->getOurTalkDataOneBeforeFirst($myId, $user_id);
    // ↑  nullでもオーケー

    // first()で取ってくると何もなかった時にnullが入ってくる。
    // get()で取ってくると何もなかった時に collectionの{#items: []}が返ってくるからその違いに注意

    // ここでは自分と相手のトークデータの最新のレコードを取ってくる
    // $talkDataNow = Talk::TalkDataNow($myId, $user_id)->first();
    $talkDataNow =  $this->TalkDataRepository->getOurTalkDataLatest($myId, $user_id);
    // ↑ nullの場合に(messageが' 'で保存されなかった場合にしたの処理をスキップする！)
    //  ↓
    if ($talkDataNow) {

      // $talkDataOneBeforeと$talkDataNowの日付を比較して同じだったらtalkCheckカラム(boolean型)にfalse違ったらtrueをいれる($talkDataOneBeforeが存在しなかった場合はtrueをいれる）
      // $talkDataNow->saveTalkCheckColumn($talkDataOneBefore);
      if ($talkDataOneBefore == null) {
        // $this->talkCheck = true;
        // $this->save();
        $this->TalkDataRepository->updateOurTalkCheckColumn($talkDataNow);
        // ↑ ここも保存用のエラーハンドリングを書く！
      } else {
        if ($talkDataOneBefore->created_at->format('n/j') != $talkDataNow->created_at->format('n/j')) {
          // $this->talkCheck = true;
          // $this->save();
          $this->TalkDataRepository->updateOurTalkCheckColumn($talkDataNow);
          // ↑ ここも保存用のエラーハンドリングを書く！
        }
      }
    }
  }



}
