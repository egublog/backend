<?php

namespace App\Repositories\Talk\Interfaces;

interface TalkDataSaveRepositoryInterface
{
   public function saveYetColumnTure($talkData);
   public function saveOurTalkData($message, $myId, $user_id);
   public function updateOurTalkCheckColumn($talkInstance);
}