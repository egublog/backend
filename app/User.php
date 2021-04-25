<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_name', 'age', 'image', 'introduction', 'area',
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



    public function alls() {
        return $this->hasMany('App\All');
    }
    
    public function follows() {
        return $this->hasMany('App\Follow', 'send_user_id');
    }
    
    public function talks() {
        return $this->hasMany('App\Talk', 'from');
    }
    public function talk_lists() {
        return $this->hasMany('App\Talk_list');
    }

    public function area() {
        return $this->belongsTo('App\Area');
    }
    
    public function getData() {
        return '名前'. ':'. $this->name. '年齢'. ':'. $this->age.'自己紹介'. ':'. $this->introduction;
    }
    
    public function show_follow()
    {
        return $this->belongsToMany('App\User', 'follows', 'send_user_id', 'receive_user_id')->withTimestamps();
    }
    
    public function show_follower()
    {
        return $this->belongsToMany('App\User', 'follows', 'receive_user_id', 'send_user_id')->withPivot('created_at')->withTimestamps();
    }
    
    public function followOrNot()
    {
        // これは使ってない
        return $this->belongsToMany('App\User', 'follows', 'send_user_id', 'receive_user_id')->wherePivot('receive_user_id', $account->id);
    }
    
    public function show_follower_activity()
    {
        return $this->belongsToMany('App\User', 'follows', 'receive_user_id', 'send_user_id')->withPivot('created_at')->orderBy('created_at', 'desc');
    }
    
    public function show_follower_time()
    {
        // これは使ってない
        return $this->belongsToMany('App\User', 'follows', 'receive_user_id', 'send_user_id')->using('App\Follow')->withPivot('created_at');
    }

  



    // ↓↓  ここから下がふぁっとモデルスキニーコントローラで書いたところ


    // ↓ get()系

    public function getFollow()
    {
        // return self::find($myId)->show_follow()->get();

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



    public function firstFollowHim($his_id) 
    {
        return $this->show_follow()->where('receive_user_id', $his_id)->first();
    }


    






    // ↓ scope系

    














    // ↓ 真偽値系
    
    public function followCheck($his_id)
    {
        return $this->firstFollowHim($his_id) === null ? false : true;
    }




    // ↓ データベース保存、削除系
    public function followAttach($user_id)
    {
        $this->show_follow()->attach($user_id);
    }

    public function followDetach($user_id)
    {
        $this->show_follow()->detach($user_id);
    }



}
