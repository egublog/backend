<?php

namespace App\packages\Domain\Application\User;

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

use App\packages\UseCase\User\Get\GetAuthUsersFriendsUseCaseInterface;
use App\Facades\IdentifyId;
use App\packages\Domain\Domain\Follow\FollowRepositoryInterface;



class GetAuthUsersFriendsInteractor implements GetAuthUsersFriendsUseCaseInterface
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
     * @param GetAuthUsersFriendsRequest $request
     * @return GetAuthUsersFriendsResponse
     */
     public function handle(GetAuthUsersFriendsRequest $request)
     {

      $identify_id = $request->getIdentify_id();

      if (IdentifyId::friendFollow($identify_id)) {
        // 自分がフォローしている人を取得
        // return  $this->UserDataRepository->getAuthUserFriendsFollow();
        $userIds = $this->followRepository->getUserIdsOfFollowParamUser($user_id);
        
      } elseif (IdentifyId::friendFollower($identify_id)) {
        // 自分をフォローしている人を取得
        // return $this->UserDataRepository->getAuthUserFriendsFollower();
        $userIds = $this->followRepository->getUserIdsOfFollowerParamUser($user_id);
      }
     }
}
