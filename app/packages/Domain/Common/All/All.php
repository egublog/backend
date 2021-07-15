<?php

namespace app\packages\Domain\Common\All;

use DateTime;
use App\Team as TeamModel;
use app\packages\Domain\Common\Team\Team;

class All
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var int
     */
    private $position_id;

    /**
     * @var int
     */
    private $team_id;

    /**
     * @var int
     */
    private $era_id;


    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;
    
    /**
     * @var Team
     */
    private $team;

    /**
     * User constructor.
     * @param int $id
     * @param int $user_id
     * @param int $position_id
     * @param int $team_id
     * @param int $era_id
     * @param DateTime $created_at
     * @param DateTime $updated_at
     */
    public function __construct(int $id, int $user_id, int $position_id, int $team_id, int $era_id, DateTime $created_at, DateTime $updated_at, TeamModel $teamModel)
    {
        $this->id = $id;
        $this->id = $user_id;
        $this->id = $position_id;
        $this->id = $team_id;
        $this->id = $era_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->team = new Team($teamModel->id, $teamModel->team_name, $teamModel->created_at, $teamModel->updated_at);

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
