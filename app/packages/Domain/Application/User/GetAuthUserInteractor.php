<?php

namespace app\packages\Domain\Application\User;

use app\packages\Domain\Domain\User\UserRepositoryInterface;
use app\packages\Domain\Domain\User\User;
use app\packages\Domain\Domain\User\UserId;
use app\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use app\packages\UseCase\User\Create\UserCreateRequest;
use app\packages\UseCase\User\Create\UserCreateResponse;

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

        $AuthUser = $this->userRepository->getAuthUser();

        
    }
}
