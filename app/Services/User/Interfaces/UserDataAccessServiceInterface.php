<?php

namespace App\Services\User\Interfaces;

interface UserDataAccessServiceInterface
{
    public function getAuthUserFriends($identify_id);
    public function AuthUserFollowCheck($his_id);
}