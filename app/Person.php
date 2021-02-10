<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    public function alls() {
        return $this->hasMany('App\All');
    }
    
    public function follows() {
        return $this->hasMany('App\Follow');
    }
    
    public function talks() {
        return $this->hasMany('App\Talk');
    }
    
    public function area() {
        return $this->belongsTo('App\area');
    }
    
    public function getData() {
        return '名前'. ':'. $this->name. '年齢'. ':'. $this->age.'自己紹介'. ':'. $this->introduction;
    }
    
    public function people()
    {
        return $this->belongsToMany('App\Person', 'follows', 'send_people_id', 'receive_people_id');
    }
    
    
}
