<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk_list extends Model
{
    //
    public function user() {
        return $this->belongsTo('App\User');
    }
}
