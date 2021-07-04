<?php

namespace App\Repositories\Talk\Interfaces;

interface TalkDataAccessRepositoryInterface
{
    public function getOurTalkYetColumnFalse($myId, $user_id);
    public function getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, $limit);
    public function getOurTalkDataOneBeforeFirst($myId, $user_id);
    public function getOurTalkDataLatest($myId, $user_id);

}