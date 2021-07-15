<?php

namespace App\packages\Domain\Application\User;

use App\packages\Domain\Domain\User\UserRepositoryInterface;
use App\packages\Domain\Domain\User\User;
use App\packages\Domain\Domain\User\UserId;
use App\packages\UseCase\User\Get\GetAuthUserUseCaseInterface;
use App\packages\UseCase\User\Create\UserCreateRequest;
use App\packages\UseCase\User\Create\UserCreateResponse;

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
