<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // リレーション ↓↓
    // public function alls()
    // {
    //     return $this->hasMany('App\All');
    // }
    public function eras()
    {
        return $this->hasMany('App\Era');
    }



    // ↓↓ scope系
    public function scopeTeamNameEqual($query, $team_string)
    {
        return $query->where('team_name', $team_string);
    }

    // ↓↓ データベース保存、削除系
    public function saveTeam($team_string)
    {
        $this->team_name = $team_string;
        $this->save();
    }
}
