<?php

namespace App\Repositories\User\Interfaces;

interface UserDataSaveRepositoryInterface
{
    public function saveAuthUserAreaid($area_id);
    public function saveAuthUserDataColumn($request, $column_name);
    public function saveAuthUserImagePathToUsersTable($path);

    public function saveAuthUserFollow($his_id);
    public function deleteAuthUserFollow($his_id);
}