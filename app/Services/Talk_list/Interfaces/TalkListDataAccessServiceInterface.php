<?php

namespace App\Services\Talk_list\Interfaces;

interface TalkListDataAccessServiceInterface
{
  public function getTalkListAccounts($myId);
  public function getOpponentIds($talk_lists, $myId);
}