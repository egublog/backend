<?php

namespace App\Repositories\Talk_list\Repositories;

use App\Repositories\Talk_list\Interfaces\TalkListDataSaveRepositoryInterface;
use App\Talk_list;




class TalkListDataSaveRepository implements TalkListDataSaveRepositoryInterface
{

  public function saveOurTalkList($myId, $user_id)
  {
    $new_talk_list = new Talk_list();
    $new_talk_list->from = $myId;
    $new_talk_list->to = $user_id;
    $new_talk_list->save();
  }

  public function deleteTalkList($talkInstance)
  {
    $talkInstance->delete();
  }

}
