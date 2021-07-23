<?php

namespace App\packages\Domain\Application\Follow;

use App\packages\Domain\Domain\User\UserRepositoryInterface;
use App\packages\Domain\Domain\User\User;
use App\packages\Domain\Domain\User\UserId;
use App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use App\packages\UseCase\User\Create\UserCreateRequest;
use App\packages\UseCase\User\Create\UserCreateResponse;
use App\packages\UseCase\User\Commons\UserModel;
use App\packages\UseCase\Era\Commons\EraModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;

use App\packages\Domain\Domain\Era\EraRepositoryInterface;
use App\packages\Domain\Domain\Team\TeamRepositoryInterface;

use  App\packages\UseCase\Follow\Get\GetBooleanAuthUserFollowUseCaseInterface;
use App\packages\UseCase\Follow\Get\GetBooleanAuthUserFollowResponse;




class GetBooleanAuthUserFollowInteractor implements GetBooleanAuthUserFollowUseCaseInterface
{

   /**
     * @var UserRepositoryInterface
     */
     private $userRepository;

    
    /**
     * @var FollwRepositoryInterface
     */
     private $follwRepository;

     
    /**
     * UserCreateInteractor constructor.
     * @param UserRepositoryInterface $userRepository
     * @param FollowRepositoryInterface $followRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, FollowRepositoryInterface $followRepository)
    {
      $this->userRepository = $userRepository;
        $this->followRepository = $followRepository;
       
    }


    /**
     * @param GetUserIdRequest $request
     * @return GetBooleanAuthUserFollowResponse
     */
     public function handle(GetUserIdRequest $request)
     {
      $authUserId = $this->userRepository->getAuthUserId();
      $follow_check = $this->followRepository->getBooleanUserfollowCheck($authUserId, $request->getUser_id());

      return new GetBooleanAuthUserFollowResponse($follow_check);



     }



}
