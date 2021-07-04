<?php

namespace App\Services\Talk\Interfaces;

interface TalkDataSaveServiceInterface
{
  public function saveYetColumnsTrue($myId, $user_id);
  public function saveOurTalkData($message, $myId, $user_id);
  public function updateOurTalkCheckColumn($myId, $user_id);

}