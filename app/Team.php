<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    public function alls() {
        return $this->hasMany('App\All');
    }
}
