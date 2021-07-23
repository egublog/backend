<?php

namespace App\packages\UseCase\User\Get;

use App\packages\UseCase\User\Get\GetAuthUsersFriendsRequest;
use App\packages\UseCase\User\Get\GetAuthUsersFriendsResponse;



interface GetAuthUsersFriendsUseCaseInterface
{
     /**
     * @param GetAuthUsersFriendsRequest $request
     * @return GetAuthUsersFriendsResponse
     */
     public function handle(GetAuthUsersFriendsRequest $request);
}
