<?php

namespace App\packages\Domain\Domain\Talk;


interface TalkRepositoryInterface
{
    // /**
    //  * @param User $user
    //  * @return mixed
    //  */
    // public function save(User $user);

    // /**
    //  * @param UserId $id
    //  * @return User
    //  */
    // public function find(UserId $id);

    /**
     * @return User
     */
    public function getAuthUser();

}
