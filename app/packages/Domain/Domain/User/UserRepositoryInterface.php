<?php

namespace App\packages\Domain\Domain\User;

use packages\Domain\Domain\User\User;


interface UserRepositoryInterface
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
    //  * @param int $page
    //  * @param int $size
    //  * @return mixed
    //  */
    // public function findByPage($page, $size);

    /**
     * @return User
     */
    public function getAuthUser();

    /**
     * @return int
     */
     public function getAuthUserId();
     
     /**
      * @param int
      * @return User
      */
      public function getUserEqualToId($userId);
}
