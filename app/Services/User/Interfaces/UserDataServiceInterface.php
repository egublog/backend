<?php

namespace App\Services\User\Interfaces;

interface UserDataServiceInterface
{
    public function getAuthUserFriends($identify_id);
    public function AuthUserFollowCheck($his_id);

    public function returnAuthUserSchoolsArrays();
//  ↓ saveから移動
public function saveAuthUserFirstAreaid();
    public function saveAuthUserDataNameIntroductionAgeArea($request);
}