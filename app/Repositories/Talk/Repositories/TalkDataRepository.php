<?php

namespace App\Repositories\Talk\Repositories;

use App\Repositories\Talk\Interfaces\TalkDataRepositoryInterface;
use App\Talk;




class TalkDataRepository implements TalkDataRepositoryInterface
{

  public function getOurTalkYetColumnFalse($myId, $user_id)
  {
    return Talk::where('from', $user_id)->where('to', $myId)->where('yet', false)->get();
  }

  public function getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, $limit)
  {
    return Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->limit($limit)->with('user')->get()->reverse()->values();
  }

  public function getOurTalkDataOneBeforeFirst($myId, $user_id)
  {
    return Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->offset(1)->limit(1)->first();
  }

  public function getOurTalkDataLatest($myId, $user_id)
  {
    return Talk::where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->first();
  }

//  ↓ saveから移動


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
