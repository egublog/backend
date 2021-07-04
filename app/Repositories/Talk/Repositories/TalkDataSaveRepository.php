<?php

namespace App\Repositories\Talk\Repositories;

use App\Repositories\Talk\Interfaces\TalkDataSaveRepositoryInterface;
use App\Talk;


class TalkDataSaveRepository implements TalkDataSaveRepositoryInterface
{

  public function saveYetColumnTure($talkData)
  {
    $talkData->yet = true;
    $talkData->save();
  }

  public function saveOurTalkData($message, $myId, $user_id)
  {
    $talkData = new Talk();
    $talkData->talk_data = $message;
    $talkData->from = $myId;
    $talkData->to = $user_id;
    $talkData->yet = false;
    $talkData->talkCheck = false;
    $talkData->save();
  }

  public function updateOurTalkCheckColumn($talkInstance)
  {
    $talkInstance->talkCheck = true;
    $talkInstance->save();
  }

}
