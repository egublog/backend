<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    public function alls() {
        return $this->hasMany('App\All');
    }
}
