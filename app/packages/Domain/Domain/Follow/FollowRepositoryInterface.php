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
    public function getUserIdsArrayOfFollowOfParamUser(int $user_id);
    
    /**
     * @param int
     * @return array
     */
    public function getUserIdsArrayOfFollowerOfParamUser(int $user_id);

    /**
     * @param int $authUserId
     * @param int $userId
     * @return bool
     */
    public function getBooleanUserfollowCheck(int $authUserId, int $userId);
}
