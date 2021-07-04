<?php

namespace App\Services\Talk_list\Services;

use App\Services\Talk_list\Interfaces\TalkListDataSaveServiceInterface;
use App\Talk_list;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Repositories\Talk_list\Interfaces\TalkListDataAccessRepositoryInterface;
use App\Repositories\Talk_list\Interfaces\TalkListDataSaveRepositoryInterface;






class TalkListDataSaveService implements TalkListDataSaveServiceInterface
{

  private $UserDataAccessRepository;
  private $TalkListDataAccessRepository;
  private $TalkListDataSaveRepository;


  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, TalkListDataAccessRepositoryInterface $TalkListDataAccessRepository, TalkListDataSaveRepositoryInterface $TalkListDataSaveRepository)
  {
    $this->UserDataAccessRepository = $UserDataAccessRepository;
    $this->TalkListDataAccessRepository = $TalkListDataAccessRepository;
    $this->TalkListDataSaveRepository = $TalkListDataSaveRepository;
  }

  public function updateOurTalkList($myId, $user_id)
  {
    // トークを送信したタイミングで自分と相手のtalk_listテーブルのレコードを取ってくる
    // $existing_talk_list =  Talk_list::ourTalkList($myId, $user_id)->first();
    $existing_talk_list = $this->TalkListDataAccessRepository->getOurTalkListFirst($myId, $user_id);

    // それがあればtalk_listsテーブルに$myId or $user_id が会ったら消す
    if (isset($existing_talk_list)) {
        // $existing_talk_list->delete();
        $this->TalkListDataSaveRepository->deleteTalkList($existing_talk_list);
    }

    // で新しくtalk_listsテーブルに自分と相手のidを追加する 。
    // $new_talk_list = new Talk_list();
    // $new_talk_list->saveNewTalkList($myId, $user_id);
      $this->TalkListDataSaveRepository->saveOurTalkList($myId, $user_id);
  }




}
