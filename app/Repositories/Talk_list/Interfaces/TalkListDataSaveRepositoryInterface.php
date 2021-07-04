<?php

namespace App\Repositories\Talk_list\Interfaces;

interface TalkListDataSaveRepositoryInterface
{
    public function deleteTalkList($talkInstance);
    public function saveOurTalkList($myId, $user_id);

}