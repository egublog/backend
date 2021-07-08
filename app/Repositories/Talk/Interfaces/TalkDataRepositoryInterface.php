<?php

namespace App\Repositories\Talk\Interfaces;

interface TalkDataRepositoryInterface
{
    public function getOurTalkYetColumnFalse($myId, $user_id);
    public function getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, $limit);
    public function getOurTalkDataOneBeforeFirst($myId, $user_id);
    public function getOurTalkDataLatest($myId, $user_id);
//  ↓ saveから移動
public function saveYetColumnTure($talkData);
public function saveOurTalkData($message, $myId, $user_id);
public function updateOurTalkCheckColumn($talkInstance);
}