<?php

namespace App\Services\Talk_list\Interfaces;

interface TalkListDataServiceInterface
{
  public function getTalkListAccounts($myId);
  public function getOpponentIds($talk_lists, $myId);
//  ↓ saveから移動
public function updateOurTalkList($myId, $user_id);

}