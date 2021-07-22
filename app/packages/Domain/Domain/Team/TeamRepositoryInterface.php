<?php

namespace App\packages\Domain\Domain\Team;


interface TeamRepositoryInterface
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
     * @param int $team_id
     * @return string
     */
     public function getTeamNameEqualTeamId(int $team_id);

}
