<?php
namespace App\MyClasses;

class IdentifyId 
{

  public function friendFollow($identify_id) 
  {
    return 'friend_follow' == $identify_id;
  }

  public function friendFollower($identify_id) 
  {
    return 'friend_follower' == $identify_id;
  }

  public function activity($identify_id) 
  {
    return 'activity' == $identify_id;
  }

  public function find($identify_id) 
  {
    return 'find' == $identify_id;
  }

  public function talkList($identify_id) 
  {
    return 'talk_list' == $identify_id;
  }

  public function talkFriendFollow($identify_id) 
  {
    return 'talk_friend_follow' == $identify_id;
  }

  public function talkFriendFollower($identify_id) 
  {
    return 'talk_friend_follower' == $identify_id;
  }

  public function talkActivity($identify_id) 
  {
    return 'talk_activity' == $identify_id;
  }

  public function talkFind($identify_id) 
  {
    return 'talk_find' == $identify_id;
  }


}





