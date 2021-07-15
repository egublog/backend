<?php

namespace App\packages\Domain\Common\All;

use DateTime;
use App\Team as TeamModel;
use App\packages\Domain\Common\Team\Team;
use Illuminate\Support\Arr;


class All
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $position_id;

    /**
     * @var int
     */
    public $team_id;

    /**
     * @var int
     */
    public $era_id;


    /**
     * @var DateTime
     */
    public $created_at;

    /**
     * @var DateTime
     */
    public $updated_at;
    
    /**
     * @var Team
     */
    public $team;

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
        $this->user_id = $user_id;
        $this->position_id = $position_id;
        $this->team_id = $team_id;
        $this->era_id = $this->changeEraIdToEraName($era_id);
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

    public function changeEraIdToEraName($value)
    {
        $eras = [
            '1' => '小学校',
            '2' => '中学校',
            '3' => '高校',
            '4' => '大学',
        ];
        
        return Arr::get($eras, $value);
    }
    
    // public function changePositionIdToPositionName($value)
    // {
    //     $eras = [
    //         '1' => 'GK',
    //         '2' => 'DF',
    //         '3' => 'MF',
    //         '4' => 'FW',
    //     ];
        
    //     return Arr::get($eras, $value);
    // }

}
