<?php

namespace App\Repositories\User\Interfaces;

interface UserDataAccessRepositoryInterface
{
    public function getAuthUser();
    public function getAuthUserId();
    public function getAuthUserAreaid();
    public function getFriendsFollow($user);
    public function getFriendsFollower($user);
    public function getFollowHimFirst($user, $his_id);

    public function getHisAccount($his_id);

    public function getAreaArray();
    public function getAuthUserTeamName($era_id);
    public function getAuthUserPositionId($era_id);

    public function getAuthUserFollowerForActivity();
    
}