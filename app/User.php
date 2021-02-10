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

  





}
