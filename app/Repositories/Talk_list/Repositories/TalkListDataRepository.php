<?php

namespace App\Repositories\Talk_list\Repositories;

use App\Repositories\Talk_list\Interfaces\TalkListDataRepositoryInterface;
use App\Talk_list;



class TalkListDataRepository implements TalkListDataRepositoryInterface
{

  public function getTalkListEqualMyid($myId)
  {
    return Talk_list::where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc')->get();
  }

  public function getOurTalkListFirst($myId, $user_id)
  {
    return Talk_list::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->first();
  }

//  ↓ saveから移動
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
