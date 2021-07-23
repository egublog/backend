<?php

namespace App\packages\UseCase\User\Get;

// use App\packages\UseCase\User\Get\GetAuthUsersFriendsRequest;
// use App\packages\UseCase\User\Get\GetUserIdRequest;
// use App\packages\UseCase\Follow\Get\GetBooleanAuthUserFollowResponse;
use App\packages\UseCase\User\Get\GetUserAccontEqualToParamRequest;
use App\packages\UseCase\User\Get\GetUserAccontEqualToParamResponse;





interface GetUserAccontEqualToParamUseCaseInterface
{
     /**
     * @param GetUserAccontEqualToParamRequest $request
     * @return GetUserAccontEqualToParamResponse
     */
     public function handle(GetUserAccontEqualToParamRequest $request);
}
