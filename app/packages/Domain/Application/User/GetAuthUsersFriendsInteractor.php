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
// use App\packages\Domain\Domain\Era\EraRepositoryInterface;
// use App\packages\Domain\Domain\Team\TeamRepositoryInterface;
use App\packages\UseCase\User\Get\GetAuthUsersFriendsResponse;
use App\packages\UseCase\User\Get\GetAuthUsersFriendsRequest;


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
     * @var EraRepositoryInterface
     */
     private $eraRepository;

     /**
      * @var TeamRepositoryInterface
      */
     private $teamRepository;
 

    /**
     * UserCreateInteractor constructor.
     * @param UserRepositoryInterface $userRepository
     * @param FollowRepositoryInterface $followRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, FollowRepositoryInterface $followRepository, EraRepositoryInterface $eraRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->userRepository = $userRepository;
        $this->followRepository = $followRepository;
        $this->eraRepository = $eraRepository;
        $this->teamRepository = $teamRepository;
       
    }

    /**
     * @param GetAuthUsersFriendsRequest $request
     * @return GetAuthUsersFriendsResponse
     */
     public function handle(GetAuthUsersFriendsRequest $request)
     {

      $identify_id = $request->getIdentify_id();

      $authUserId = $this->userRepository->getAuthUserId();

      $userIds = [];
      if (IdentifyId::friendFollow($identify_id)) {
        // 自分がフォローしている人を取得
        // return  $this->UserDataRepository->getAuthUserFriendsFollow();
        $userIds = $this->followRepository->getUserIdsArrayOfFollowOfParamUser($authUserId);
      } elseif (IdentifyId::friendFollower($identify_id)) {
        // 自分をフォローしている人を取得
        // return $this->UserDataRepository->getAuthUserFriendsFollower();
        $userIds = $this->followRepository->getUserIdsArrayOfFollowerOfParamUser($authUserId);
      }

      $accounts = [];
      if($userIds)
      {
        foreach($userIds as $userId)
        {
          $eraEntityArray = $this->eraRepository->getEraArrayEqualUserId($userId);
          $eraCommonModelArray = [];
          foreach($eraEntityArray as $eraEntity)
          {
              $eraCommonModelArray[] = new EraModel($eraEntity->getId(), $eraEntity->getUser_id(), $eraEntity->getPosition_id(), $this->teamRepository->getTeamNameEqualTeamId($eraEntity->getTeam_id()), $eraEntity->getEra_id());
          }

          $userEntity = $this->userRepository->getUserEqualToId($userId);


          $userCommonModel = new UserModel($userEntity->getId(), $userEntity->getName(), $userEntity->getEmail(), $userEntity->getUser_name(), $userEntity->getAge(), $userEntity->getImage(), $userEntity->getIntroduction(), $userEntity->getArea_id(), $eraCommonModelArray);

          $accounts[] = $userCommonModel;
        }
      }

      // return $accounts;
      return new GetAuthUsersFriendsResponse($accounts);

     }
}
