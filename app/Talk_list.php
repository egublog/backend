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



    public function scopeOurTalkList($query, $myId, $user_id)
    {
        return $query->where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId);
    }


        // ↓ データベース保存、削除系

    public function saveNewTalkList($myId, $user_id)
    {
        $this->from = $myId;
        $this->to = $user_id;
        $this->save();
    }



}
