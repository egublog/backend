<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class All extends Model
{
    //
    public function position() {
        return $this->belongsTo('App\Position');
    }
    
    public function team() {
        return $this->belongsTo('App\Team');
    }
    
    public function era() {
        return $this->belongsTo('App\Era');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function area() {
        return $this->belongsTo('App\Area');
    }
}
