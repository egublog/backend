<?php

namespace App\packages\Domain\Domain\Follow;


interface FollowRepositoryInterface
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
