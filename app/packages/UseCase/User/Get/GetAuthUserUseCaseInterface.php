<?php

namespace app\packages\UseCase\User\Get;


interface GetAuthUserUseCaseInterface
{
    /**
     * 
     * @return GetAuthUserResponse
     */
    public function handle();
}
