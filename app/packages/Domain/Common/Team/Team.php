<?php

namespace app\packages\Domain\Common\Team;

use DateTime;
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
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;
    

    /**
     * User constructor.
     * @param int $id
     * @param string $team_name
     * @param DateTime $created_at
     * @param DateTime $updated_at
     */
    public function __construct(int $id, string $team_name, DateTime $created_at, DateTime $updated_at)
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
    public function getName(): string
    {
        return $this->name;
    }
}
