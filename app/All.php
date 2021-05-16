<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;


class All extends Model
{
    //

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'position_id', 'team_id', 'era_id'
    ];

    // リレーション ↓↓
    // public function position() {
    //     return $this->belongsTo('App\Position');
    // }
    
    public function team() {
        return $this->belongsTo('App\Team');
    }
    
    // public function era() {
    //     return $this->belongsTo('App\Era');
    // }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    // public function area() {
    //     return $this->belongsTo('App\Area');
    // }

    
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
    
    public function changePositionIdToPositionName($value)
    {
        $eras = [
            '1' => 'GK',
            '2' => 'DF',
            '3' => 'MF',
            '4' => 'FW',
        ];
        
        return Arr::get($eras, $value);
    }


    // アクセサ ↓↓
    // public function getEraIdAttribute($value)
    // {
        //     $eras = [
            //         '1' => '小学校',
    //         '2' => '中学校',
    //         '3' => '高校',
    //         '4' => '大学',
    //     ];

    //     return Arr::get($eras, $value);
    // }
    
    // public function getPositionIdAttribute($value)
    // {
    //     $eras = [
    //         '1' => 'GK',
    //         '2' => 'DF',
    //         '3' => 'MF',
    //         '4' => 'FW',
    //     ];

    //     return Arr::get($eras, $value);
    // }





    // ↓↓  ここから下がふぁっとモデルスキニーコントローラで書いたところ


    // ↓ get()系

    public static function getSearchAll($era_id, $team_id)
    {
        return self::where('era_id', $era_id)->where('team_id', $team_id)->with('user')->get();
    }



        // ↓ scope系
    public function scopeMyIdEraEqual($query, $myId, $era_id)
    {
        return $query->where('user_id', $myId)->where('era_id', $era_id);
    }


        // ↓ データベース保存、削除系
    public function saveTeamIdAndPositionId($team_id, $position_id)
    {
        $this->team_id = $team_id;
        $this->position_id = $position_id;
        $this->save();
    }


}
