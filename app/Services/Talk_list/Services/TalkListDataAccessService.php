<?php

namespace App\Services\Talk_list\Services;

use App\Services\Talk_list\Interfaces\TalkListDataAccessServiceInterface;
use App\Talk_list;
use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Repositories\Talk_list\Interfaces\TalkListDataAccessRepositoryInterface;






class TalkListDataAccessService implements TalkListDataAccessServiceInterface
{

  private $UserDataAccessRepository;
  private $TalkListDataAccessRepository;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, TalkListDataAccessRepositoryInterface $TalkListDataAccessRepository)
  {
    $this->UserDataAccessRepository = $UserDataAccessRepository;
    $this->TalkListDataAccessRepository = $TalkListDataAccessRepository;
  }



  public function getTalkListAccounts($myId)
  {

    // $talk_lists = Talk_list::fromToEqual($myId)->get();
    $talk_lists = $this->TalkListDataAccessRepository->getTalkListEqualMyid($myId);

    $opponent_ids = $this->getOpponentIds($talk_lists, $myId);

    $talk_lists_accounts = array();
    foreach ($opponent_ids as $id) {
      // $talk_lists_accounts[] = User::find($id);
      $talk_lists_accounts[] = $this->UserDataAccessRepository->getHisAccount($id);
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


}
