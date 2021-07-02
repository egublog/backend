<?php

namespace App\Repositories\All\Interfaces;

interface AllDataAccessRepositoryInterface
{
    public function getAllFirst($myId);
    public function getAllDataUseridEraidEqual($myId, $era_id);
}