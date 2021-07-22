<?php

namespace App\packages\Domain\Domain\Team;

// use DateTime;
// use App\Team as TeamModel;
// use packages\Domain\Common\Team\Team;

class Team
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
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;
    

    /**
     * User constructor.
     * @param int $id
     * @param string $team_name
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(int $id, string $team_name, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->team_name = $team_name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

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

    /**
     * @return string
     */
    public function getCreated_at(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdated_at(): string
    {
        return $this->updated_at;
    }

}
