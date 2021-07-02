<?php

namespace App\Repositories\Talk\Interfaces;

interface TalkDataAccessRepositoryInterface
{
    public function getOurTalkYetColumnFalse($myId, $user_id);
    public function getOurTalkDatasLatestLimitOrderByOldest($myId, $user_id, $limit);
}