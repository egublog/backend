<?php

namespace App\Repositories\Talk_list\Interfaces;

interface TalkListDataAccessRepositoryInterface
{
    public function getTalkListEqualMyid($myId);
}