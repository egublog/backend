<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk_list extends Model
{
    //
    public function user() {
        return $this->belongsTo('App\User');
    }





    // ↓ scope系

    public function scopeFromToEqual($query, $myId)
    {
        return $query->where('from', $myId)->orWhere('to', $myId)->orderBy('created_at', 'desc');
    }






}
