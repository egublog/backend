<?php

namespace App\packages\Domain\Application\User;

use App\packages\Domain\Domain\User\UserRepositoryInterface;
use App\packages\Domain\Domain\User\User;
use App\packages\Domain\Domain\User\UserId;
use App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use App\packages\UseCase\User\Create\UserCreateRequest;
use App\packages\UseCase\User\Create\UserCreateResponse;
use App\packages\UseCase\User\Commons\UserModel;
use App\packages\UseCase\User\Get\GetAuthUserResponse;

class GetAuthUserInteractor implements GetAuthUserUseCaseInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserCreateInteractor constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserCreateRequest $request
     * @return UserCreateResponse
     */
    public function handle()
    {
        // $userId = new UserId(uniqid());
        // $createdUser = new User($userId, $request->getName());
        // $this->userRepository->save($createdUser);

        // return new UserCreateResponse($userId->getValue());

        $AuthUserEntity = $this->userRepository->getAuthUser();

        
        // dd($AuthUserEntity);
        // dd($AuthUserEntity->getArea_id());
        $AuthUserCommoModel = new UserModel($AuthUserEntity->getId(), $AuthUserEntity->getName(), $AuthUserEntity->getEmail(), $AuthUserEntity->getUser_name(), $AuthUserEntity->getAge(), $AuthUserEntity->getImage(), $AuthUserEntity->getIntroduction(), $AuthUserEntity->getArea_id(), $AuthUserEntity->getCreated_at(), $AuthUserEntity->getUpdated_at(), $AuthUserEntity->getAlls());
        // ↑  ％％でここでの詰め替えはエンティティからUseCase層用のインスタンスに詰め替えている％％

        return new GetAuthUserResponse($AuthUserCommoModel);
        // ↑ 今回はUserインスタンスだけだからただの詰め替え作業みたいになってるけど、ここのユースケースでUser以外のデータも渡す
        //    場合があるからここは必要、例えば $talk_datas , $myAccount, $his_account とか多くのデータをコントローラに
        //    渡す時はここでまとめて一つのレスポンスとして返す！！

        
    }
}
