<?php

namespace App\Http\Models\Era\Commons;

// こいつはただデータをこの型にしたいだけのただの格納器
// ($era->id, $era->era_id, $era->team_name, $era_position_id)
use Illuminate\Support\Arr;


  class EraViewModelForProfile
  {
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $era_name_head;

    /**
     * @var string
     */
    public $era_team_head;

    /**
     * @var string
     */
    public $era_position_head;
    /**
     * @var string
     */
    public $team_name;
    /**
     * @var string
     */
    public $position_id;

// ($era->id, $era->era_id, $era->team_name, $era_position_id)


    /**
     * User constructor.
     * @param int $id
     * @param int $era_id
     * @param string $team_name
     * @param int $position_id
     */
    public function __construct(int $id, int $era_id, string $team_name, int $position_id)
    {
        $this->id = $id;
        $this->era_name_head = $this->changeEraIdToEraNameHead($era_id);
        $this->era_team_head = $this->changeEraIdToEraTeamHead($era_id);
        $this->era_position_head = $this->changeEraIdToEraPositionHead($era_id);
        $this->team_name = $team_name;
        $this->position_id = $position_id;
    }

    // ['小学校の所属チーム', 'elementaryTeam', 'elementaryPosition', $elementaryTeam, $elementaryPosition],
        //     ['中学校の所属チーム', 'juniorHighTeam', 'juniorHighPosition', $juniorHighTeam, $juniorHighPosition],
        //     ['高校の所属チーム', 'highTeam', 'highPosition', $highTeam, $highPosition],
        //     ['大学の所属チーム', 'universityTeam', 'universityPosition', $universityTeam, $universityPosition]

    private function changeEraIdToEraNameHead($value)
    {
        $eras = [
            '1' => '小学校の所属チーム',
            '2' => '中学校の所属チーム',
            '3' => '高校の所属チーム',
            '4' => '大学の所属チーム',
        ];
        
        return Arr::get($eras, $value);
    }
    
    
    private function changeEraIdToEraTeamHead($value)
    {
        $eras = [
            '1' => 'elementaryTeam',
            '2' => 'juniorHighTeam',
            '3' => 'highTeam',
            '4' => 'universityTeam',
        ];
        
        return Arr::get($eras, $value);
    }
    
    
    private function changeEraIdToEraPositionHead($value)
    {
        $eras = [
            '1' => 'elementaryPosition',
            '2' => 'juniorHighPosition',
            '3' => 'highPosition',
            '4' => 'universityPosition',
        ];
        
        return Arr::get($eras, $value);
    }
    
    

}
