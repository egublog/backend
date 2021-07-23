<?php

namespace App\packages\UseCase\Follow\Get;

// use App\packages\UseCase\User\Get\GetAuthUsersFriendsRequest;
use App\packages\UseCase\User\Get\GetUserIdRequest;
use App\packages\UseCase\Follow\Get\GetBooleanAuthUserFollowResponse;




interface GetBooleanAuthUserFollowUseCaseInterface
{
     /**
     * @param GetUserIdRequest $request
     * @return GetBooleanAuthUserFollowResponse
     */
     public function handle(GetUserIdRequest $request);
}
