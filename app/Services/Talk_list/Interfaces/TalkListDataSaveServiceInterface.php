<?php

namespace App\Services\Talk_list\Interfaces;

interface TalkListDataSaveServiceInterface
{
  public function updateOurTalkList($myId, $user_id);
}