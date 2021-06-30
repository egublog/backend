<?php

namespace App\Repositories\User\Interfaces;

interface UserDataAccessRepositoryInterface
{
    public function getAuthUser();
    public function getAuthUserId();
    public function getAuthUserAreaid();
}