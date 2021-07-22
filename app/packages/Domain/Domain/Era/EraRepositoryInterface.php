<?php

namespace App\packages\Domain\Domain\Era;


interface EraRepositoryInterface
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
     * @param int $user_id
     * @return array
     */
     public function getEraArrayEqualUserId(int $user_id)

}
