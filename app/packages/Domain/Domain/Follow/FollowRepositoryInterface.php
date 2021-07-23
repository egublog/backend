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

    // /**
    //  * @return User
    //  */
    // public function getAuthUser();

    /**
     * @param int
     * @return array
     */
    public function getUserIdsArrayOfFollowOfParamUser($user_id);
    
    /**
     * @param int
     * @return array
     */
    public function getUserIdsArrayOfFollowerOfParamUser($user_id);
}
