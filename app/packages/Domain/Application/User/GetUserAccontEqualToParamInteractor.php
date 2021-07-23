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

// use  App\packages\UseCase\Follow\Get\GetBooleanAuthUserFollowUseCaseInterface;
// use App\packages\UseCase\Follow\Get\GetBooleanAuthUserFollowResponse;

use App\packages\UseCase\User\Get\GetUserAccontEqualToParamRequest;
use App\packages\UseCase\User\Get\GetUserAccontEqualToParamResponse;

use App\packages\UseCase\User\Get\GetUserAccontEqualToParamUseCaseInterface;

use App\packages\Domain\Domain\Follow\FollowRepositoryInterface;






class GetUserAccontEqualToParamInteractor implements GetUserAccontEqualToParamUseCaseInterface
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
     * @param GetUserAccontEqualToParamRequest $request
     * @return GetUserAccontEqualToParamResponse
     */
     public function handle(GetUserAccontEqualToParamRequest $request)
   {
        $UserEntity = $this->userRepository->getUserEqualToId($request->getUser_id());
        // dd($AuthUserEntity->getId());
        $authUserId = $this->userRepository->getAuthUserId();


        $eraEntityArray = $this->eraRepository->getEraArrayEqualUserId($UserEntity->getId());

        // dd($eraEntityArray);

        $eraCommonModelArray = [];
        foreach($eraEntityArray as $eraEntity)
        {
            $eraCommonModelArray[] = new EraModel($eraEntity->getId(), $eraEntity->getUser_id(), $eraEntity->getPosition_id(), $this->teamRepository->getTeamNameEqualTeamId($eraEntity->getTeam_id()), $eraEntity->getEra_id());
        }

        // dd($eraCommonModelArray);

        
        // dd($AuthUserEntity);
        // dd($AuthUserEntity->getArea_id());
        // $AuthUserCommoModel = new UserModel($AuthUserEntity->getId(), $AuthUserEntity->getName(), $AuthUserEntity->getEmail(), $AuthUserEntity->getUser_name(), $AuthUserEntity->getAge(), $AuthUserEntity->getImage(), $AuthUserEntity->getIntroduction(), $AuthUserEntity->getArea_id(), $AuthUserEntity->getCreated_at(), $AuthUserEntity->getUpdated_at(), $AuthUserEntity->getAlls());
        $UserCommonModel = new UserModel($UserEntity->getId(), $UserEntity->getName(), $UserEntity->getEmail(), $UserEntity->getUser_name(), $UserEntity->getAge(), $UserEntity->getImage(), $UserEntity->getIntroduction(), $UserEntity->getArea_id(), $eraCommonModelArray, $this->followRepository->getBooleanUserfollowCheck($authUserId, $UserEntity->getId()));
        // ↑  このUserModelの中で詰め替えをしてしまうとネストして分かりにくくなるからここで作ってから入れる
        // ↑  ％％でここでの詰め替えはエンティティからUseCase層用のインスタンスに詰め替えている％％

        return new GetUserAccontEqualToParamResponse($UserCommonModel);
   }
}
