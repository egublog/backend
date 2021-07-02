<?php

namespace App\Repositories\Talk_list\Repositories;

use App\Repositories\Talk_list\Interfaces\TalkListDataAccessRepositoryInterface;
use App\Talk_list;




class TalkListDataAccessRepository implements TalkListDataAccessRepositoryInterface
{


  public function getTalkListEqualMyid($myId)
  {
    return Talk_list::where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc')->get();
  }




}
