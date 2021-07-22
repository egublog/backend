<?php

namespace App\packages\UseCase\Team\Commons;


// use DateTime;
// use App\Team as TeamModel;
// use packages\Domain\Common\Team\Team;

class TeamModel
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $team_name;

    /**
     * User constructor.
     * @param int $id
     * @param string $team_name
     */
    public function __construct(int $id, string $team_name)
    {
        $this->id = $id;
        $this->team_name = $team_name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTeam_name(): string
    {
        return $this->team_name;
    }

}
