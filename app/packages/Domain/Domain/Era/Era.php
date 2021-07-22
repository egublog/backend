<?php

namespace App\packages\Domain\Domain\Era;

// use DateTime;


class Era
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
     * @param int $user_id
     * @param int $position_id
     * @param int $team_id
     * @param int $era_id
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(int $id, int $user_id, int $position_id, int $team_id, int $era_id, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->position_id = $position_id;
        $this->team_id = $team_id;
        $this->era_id = $era_id;
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
     * @return int
     */
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    
    /**
     * @return int
     */
    public function getPosition_id(): int
    {
        return $this->position_id;
    }

    
    /**
     * @return int
     */
    public function getTeam_id(): int
    {
        return $this->team_id;
    }

    
    /**
     * @return int
     */
    public function getEra_id(): int
    {
        return $this->era_id;
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
 




    // public function changeEraIdToEraName($value)
    // {
    //     $eras = [
    //         '1' => '小学校',
    //         '2' => '中学校',
    //         '3' => '高校',
    //         '4' => '大学',
    //     ];
        
    //     return Arr::get($eras, $value);
    // }
    
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
