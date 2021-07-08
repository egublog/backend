<?php

namespace App\Repositories\Talk_list\Interfaces;

interface TalkListDataRepositoryInterface
{
    public function getTalkListEqualMyid($myId);
    public function getOurTalkListFirst($myId, $user_id);
//  ↓ saveから移動
public function deleteTalkList($talkInstance);
    public function saveOurTalkList($myId, $user_id);
}