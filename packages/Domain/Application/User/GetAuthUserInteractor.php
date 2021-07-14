<?php

namespace packages\Domain\Application\User;

use packages\Domain\Domain\User\UserRepositoryInterface;
use packages\Domain\Domain\User\User;
use packages\Domain\Domain\User\UserId;
use packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use packages\UseCase\User\Create\UserCreateRequest;
use packages\UseCase\User\Create\UserCreateResponse;

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
