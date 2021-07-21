<?php

namespace App;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;



class User extends Authenticatable
{
    use Notifiable;

    /**
     * 属性に対するモデルのデフォルト値
     *
     * @var array
     */
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_name', 'age', 'image', 'introduction', 'area', 'area_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'area_id' => 50,
    ];


    // リレーション↓↓


    // public function alls() {
    //     return $this->hasMany('App\All');
    // }
    public function eras() {
        return $this->hasMany('App\Era');
    }
    
    public function follows() {
        return $this->hasMany('App\Follow', 'send_user_id');
    }
    
    public function talks() {
        return $this->hasMany('App\Talk', 'from');
    }
    public function talk_lists() {
        return $this->hasMany('App\Talk_list', 'from');
    }
    
    public function show_follow()
    {
        return $this->belongsToMany('App\User', 'follows', 'send_user_id', 'receive_user_id')->withTimestamps();
    }
    
    public function show_follower()
    {
        return $this->belongsToMany('App\User', 'follows', 'receive_user_id', 'send_user_id')->withPivot('created_at')->withTimestamps();
    }
    
    public function show_follower_activity()
    {
        return $this->belongsToMany('App\User', 'follows', 'receive_user_id', 'send_user_id')->withPivot('created_at')->orderBy('created_at', 'desc');
    }
    
    
    
    public function changeAreaIdToPrefecturesName($value)
    {
        $prefs = [
            '1' => '北海道',
            '2' => '青森県',
            '3' => '岩手県',
            '4' => '宮城県',
            '5' => '秋田県',
            '6' => '山形県',
            '7' => '福島県',
            '8' => '茨城県',
            '9' => '栃木県',
            '10' => '群馬県',
            '11' => '埼玉県',
            '12' => '千葉県',
            '13' => '東京都',
            '14' => '神奈川県',
            '15' => '新潟県',
            '16' => '富山県',
            '17' => '石川県',
            '18' => '福井県',
            '19' => '山梨県',
            '20' => '長野県',
            '21' => '岐阜県',
            '22' => '静岡県',
            '23' => '愛知県',
            '24' => '三重県',
            '25' => '滋賀県',
            '26' => '京都府',
            '27' => '大阪府',
            '28' => '兵庫県',
            '29' => '奈良県',
            '30' => '和歌山県',
            '31' => '鳥取県',
            '32' => '島根県',
            '33' => '岡山県',
            '34' => '広島県',
            '35' => '山口県',
            '36' => '徳島県',
            '37' => '香川県',
            '38' => '愛媛県',
            '39' => '高知県',
            '40' => '福岡県',
            '41' => '佐賀県',
            '42' => '長崎県',
            '43' => '熊本県',
            '44' => '大分県',
            '45' => '宮崎県',
            '46' => '鹿児島県',
            '47' => '沖縄県',
            '48' => '海外',
            '49' => 'その他',
            '50' => '未設定です',
        ];

        if($value === null)
        {
            return $value;
        }

        return Arr::get($prefs, $value);
    }
   



    // ↓↓ ↓↓ ここから下がふぁっとモデルスキニーコントローラで書いたところ



    // ↓↓ get()系  （主にリレーションを含む時）

    public function returnTeamName($era_id)
    {
        // return $this->alls()->where('era_id', $era_id)->first()->team->team_name;
        return $this->eras()->where('era_id', $era_id)->first()->team->team_name;
    }

    public function returnPositionId($era_id)
    {
        // return $this->alls()->where('era_id', $era_id)->first()->position_id;
        return $this->eras()->where('era_id', $era_id)->first()->position_id;
    }

    public function getFollow()
    {
        return $this->show_follow()->get();
    }
    
    public function getFollower()
    {
        return $this->show_follower()->get();
    }


    public function getFollowerActivity() 
    {
        return $this->show_follower_activity()->get();
    }


    //↓ getFollowHimFirst($user, $his_id)  Repository
    public function firstFollowHim($his_id) 
    {
        return $this->show_follow()->where('receive_user_id', $his_id)->first();
    }




    // ↓↓ 真偽値系

    // ↓ AuthUserFollowCheck($his_id)  Service
    public function followCheck($his_id)
    {
        return $this->firstFollowHim($his_id) === null ? false : true;
    }




    // ↓↓ データベース保存、削除系
    public function followAttach($user_id)
    {
        $this->show_follow()->attach($user_id);
    }

    public function followDetach($user_id)
    {
        $this->show_follow()->detach($user_id);
    }

    public function saveColumn($request ,$column_name)
    {
        $this->$column_name = $request->$column_name;
        $this->save();
    }

    public function saveImagePathToUsersTable($path)
    {
        $this->image = Storage::disk('s3')->url($path);
        $this->save();
    }



}
