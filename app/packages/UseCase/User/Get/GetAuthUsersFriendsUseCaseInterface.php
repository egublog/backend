<?php

namespace App\packages\UseCase\User\Get;

use App\packages\UseCase\User\Get\GetAuthUsersFriendsRequest;



interface GetAuthUsersFriendsUseCaseInterface
{
     /**
     * @param GetAuthUsersFriendsRequest $request
     * @return GetAuthUsersFriendsResponse
     */
     public function handle(GetAuthUsersFriendsRequest $request);
}
