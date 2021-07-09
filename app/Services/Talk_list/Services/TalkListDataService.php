<?php

namespace App\Services\Talk_list\Services;

use App\Services\Talk_list\Interfaces\TalkListDataServiceInterface;
use App\Talk_list;
use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Repositories\Talk_list\Interfaces\TalkListDataRepositoryInterface;
//  ↓ saveから移動

// use App\Services\Talk_list\Interfaces\TalkListDataSaveServiceInterface;
// use App\Talk_list;

// use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
// use App\Repositories\Talk_list\Interfaces\TalkListDataAccessRepositoryInterface;
// use App\Repositories\Talk_list\Interfaces\TalkListDataSaveRepositoryInterface;






class TalkListDataService implements TalkListDataServiceInterface
{

  private $UserDataRepository;
  private $TalkListDataRepository;


  public function __construct(UserDataRepositoryInterface $UserDataRepository, TalkListDataRepositoryInterface $TalkListDataRepository)
  {
    $this->UserDataRepository = $UserDataRepository;
    $this->TalkListDataRepository = $TalkListDataRepository;
  }



  public function getTalkListAccounts($myId)
  {

    // $talk_lists = Talk_list::fromToEqual($myId)->get();
    $talk_lists = $this->TalkListDataRepository->getTalkListEqualMyid($myId);

    $opponent_ids = $this->getOpponentIds($talk_lists, $myId);

    $talk_lists_accounts = array();
    foreach ($opponent_ids as $id) {
      // $talk_lists_accounts[] = User::find($id);
      $talk_lists_accounts[] = $this->UserDataRepository->getHisAccount($id);
    }

    return $talk_lists_accounts;
  }

  public function getOpponentIds($talk_lists, $myId)
  {
    // 引数のtalk_listsレコード達から相手のidだけを抜き取って配列にしてreturnする
    $opponent_ids = array();
    foreach ($talk_lists as $talk_list) {
      if ($talk_list->to != $myId) {
        $opponent_ids[] = $talk_list->to;
      }
      if ($talk_list->from != $myId) {
        $opponent_ids[] = $talk_list->from;
      }
    }

    return $opponent_ids;
  }
  
//  ↓ saveから移動


  // private $UserDataAccessRepository;
  // private $TalkListDataAccessRepository;
  // private $TalkListDataSaveRepository;


  // public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, TalkListDataAccessRepositoryInterface $TalkListDataAccessRepository, TalkListDataSaveRepositoryInterface $TalkListDataSaveRepository)
  // {
  //   $this->UserDataAccessRepository = $UserDataAccessRepository;
  //   $this->TalkListDataAccessRepository = $TalkListDataAccessRepository;
  //   $this->TalkListDataSaveRepository = $TalkListDataSaveRepository;
  // }

  public function updateOurTalkList($myId, $user_id)
  {
    // トークを送信したタイミングで自分と相手のtalk_listテーブルのレコードを取ってくる
    // $existing_talk_list =  Talk_list::ourTalkList($myId, $user_id)->first();
    $existing_talk_list = $this->TalkListDataRepository->getOurTalkListFirst($myId, $user_id);

    // それがあればtalk_listsテーブルに$myId or $user_id が会ったら消す
    if (isset($existing_talk_list)) {
        // $existing_talk_list->delete();
        $this->TalkListDataRepository->deleteTalkList($existing_talk_list);
    }

    // で新しくtalk_listsテーブルに自分と相手のidを追加する 。
    // $new_talk_list = new Talk_list();
    // $new_talk_list->saveNewTalkList($myId, $user_id);
      $this->TalkListDataRepository->saveOurTalkList($myId, $user_id);
  }



}
