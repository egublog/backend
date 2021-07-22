<?php

namespace App\packages\UseCase\Era\Commons;


// use DateTime;


class EraModel
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
    public $team_name;

    /**
     * @var int
     */
    public $era_id;

    
    /**
     * @var int
     */
    public $position_name;

    /**
     * @var int
     */
    public $era_name;


    /**
     * User constructor.
     * @param int $id
     * @param int $user_id
     * @param int $position_id
     * @param int $team_name
     * @param int $era_id
     */
    public function __construct(int $id, int $user_id, int $position_id, int $team_name, int $era_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->position_id = $position_id;
        $this->team_name = $team_name;
        $this->era_id = $era_id;

        $this->position_name = $this->changePositionIdToPositionName($position_id);
        $this->era_nane = $this->changeEraIdToEraName($era_id);
    }

    

    private function changeEraIdToEraName($value)
    {
        $eras = [
            '1' => '小学校',
            '2' => '中学校',
            '3' => '高校',
            '4' => '大学',
        ];
        
        return Arr::get($eras, $value);
    }
    
    private function changePositionIdToPositionName($value)
    {
        $eras = [
            '1' => 'GK',
            '2' => 'DF',
            '3' => 'MF',
            '4' => 'FW',
        ];
        
        return Arr::get($eras, $value);
    }

}
