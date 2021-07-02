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


}
