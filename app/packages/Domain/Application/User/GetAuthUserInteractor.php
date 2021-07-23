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



class GetAuthUserInteractor implements GetAuthUserUseCaseInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

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
     */
    public function __construct(UserRepositoryInterface $userRepository, EraRepositoryInterface $eraRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->userRepository = $userRepository;
        $this->eraRepository = $eraRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
    //  * @param UserCreateRequest $request
    //  * @return UserCreateResponse
     * @return GetAuthUserResponse
     */
    public function handle()
    {
        // $userId = new UserId(uniqid());
        // $createdUser = new User($userId, $request->getName());
        // $this->userRepository->save($createdUser);

        // return new UserCreateResponse($userId->getValue());

        $AuthUserEntity = $this->userRepository->getAuthUser();
        // dd($AuthUserEntity->getId());

        $eraEntityArray = $this->eraRepository->getEraArrayEqualUserId($AuthUserEntity->getId());

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
        $AuthUserCommonModel = new UserModel($AuthUserEntity->getId(), $AuthUserEntity->getName(), $AuthUserEntity->getEmail(), $AuthUserEntity->getUser_name(), $AuthUserEntity->getAge(), $AuthUserEntity->getImage(), $AuthUserEntity->getIntroduction(), $AuthUserEntity->getArea_id(), $eraCommonModelArray, false);
        // ↑  このUserModelの中で詰め替えをしてしまうとネストして分かりにくくなるからここで作ってから入れる
        // ↑  ％％でここでの詰め替えはエンティティからUseCase層用のインスタンスに詰め替えている％％

        return new GetAuthUserResponse($AuthUserCommonModel);
        // ↑ 今回はUserインスタンスだけだからただの詰め替え作業みたいになってるけど、ここのユースケースでUser以外のデータも渡す
        //    場合があるからここは必要、例えば $talk_datas , $myAccount, $his_account とか多くのデータをコントローラに
        //    渡す時はここでまとめて一つのレスポンスとして返す！！


        // ここのユースケース層でビジネスロジックを構成するとのこと、エンティティでは単純にデータベースを表現するだけ！

        
    }
}
