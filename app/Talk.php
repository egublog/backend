<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    //
    public function user() {
        return $this->belongsTo('App\User', 'from');
    }




    // ↓ scope系

    public function scopeYetColumnsFalse($query, $myId, $user_id)
    {
        return $query->where('from', $user_id)->where('to', $myId)->where('yet', false);
    }

    public function scopeTalkDatasLatestLimit($query, $myId, $user_id, $limitNumber)
    {
        return $query->where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->limit($limitNumber);
    }

    public function scopeTalkDataOneBefore($query, $myId, $user_id)
    {
        return $query->where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc')->offset(1)->limit(1);
        // ->skip(1)でいけるし、、後でfirst()で取得しているから->limit(1)は要らない
    }
    
    public function scopeTalkDataNow($query, $myId, $user_id)
    {
        return $query->where('from', $myId)->where('to', $user_id)->orWhere('from', $user_id)->where('to', $myId)->orderBy('created_at', 'desc');
    }





            // ↓ データベース保存、削除系
    public function saveNewTalk($message, $myId, $user_id)
    {
        $this->talk_data = $message;
        $this->from = $myId;
        $this->to = $user_id;
        $this->yet = false;
        $this->talkCheck = false;
        $this->save();
    }

    public function saveTalkCheckColumn($talkDataOneBefore)
    {
        if ($talkDataOneBefore == null) {
            $this->talkCheck = true;
            $this->save();
        } else {
            if ($talkDataOneBefore->created_at->format('n/j') != $this->created_at->format('n/j')) {
                $this->talkCheck = true;
                $this->save();
            }
        }
    }

}
