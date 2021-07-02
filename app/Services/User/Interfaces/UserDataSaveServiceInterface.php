<?php

namespace App\Services\User\Interfaces;

interface UserDataSaveServiceInterface
{
    public function saveAuthUserFirstAreaid();
    public function saveAuthUserDataNameIntroductionAgeArea($request);
}