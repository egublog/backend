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

//  ↓ saveから移動
    

    public function saveAuthUserAreaid($area_id);
    public function saveAuthUserDataColumn($request, $column_name);
    public function saveAuthUserImagePathToUsersTable($path);

    public function saveAuthUserFollow($his_id);
    public function deleteAuthUserFollow($his_id);
    
}