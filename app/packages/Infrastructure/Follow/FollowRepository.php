<?php

namespace App\packages\Infrastructure\Follow;


// use Illuminate\Support\Facades\DB;
use App\packages\Domain\Domain\Follow\Follow;
// use packages\Domain\Domain\User\UserId;
use App\packages\Domain\Domain\Follow\FollowRepositoryInterface;
// use Illuminate\Support\Facades\Auth;
// use App\User as UserModel;
use App\Follow as FollowModel;
use Carbon\Carbon;

class FollowRepository implements FollowRepositoryInterface
{
    // /**
    //  * @param UserId $id
    //  * @return User
    //  */
    // public function find(UserId $id)
    // {
    //     $user = DB::table('users')->where('id', $id->getValue())->first();

    //     return new User($id, $user->name);
    //     // ↑　ここでデータベースからとってきた生の情報をエンティティに格納してreturn
    // }

    // /**
    //  * @param int $page
    //  * @param int $size
    //  * @return mixed
    //  */
    // public function findByPage($page, $size)
    // {
    //     // TODO: Implement findByPage() method.
    // }

    /**
     * @param int $team_id
     * @return string
     */
    public function getTeamNameEqualTeamId(int $team_id)
    {
        // $user = UserModel::where('id', Auth::id())->first();
        $team = TeamModel::where('id', $team_id)->first();

        // return new Team($team->id, $team->team_name, (new Carbon($team->created_at))->toDateTimeString(), (new Carbon($team->updated_at))->toDateTimeString());
        return $team->team_name;
        // ↑  リポジトリ層だからって全部エンティティを返さなくていい。ただエロクエントを漏らさなきゃいい

        

        // return new User($user->id, $user->name, $user->email, $user->user_name, $user->age, $user->image, $user->introduction, $user->area_id, (new Carbon($user->created_at))->toDateTimeString(), (new Carbon($user->updated_at))->toDateTimeString());
        
    }

    /**
     * @param int
     * @return array
     */
     public function getUserIdsArrayOfFollowOfParamUser($user_id)
     {
       $followCollectionOfUserIds = Follow::where('send_user_id', $user_id)->pluck('receive_user_id');

       $userIdsArray = [];
       foreach($followCollectionOfUserIds as $user_id)
       {
         $userIdsArray[] = $user_id;
       }

       return $userIdsArray;
     }
     
     /**
      * @param int
      * @return array
      */
      public function getUserIdsArrayOfFollowerOfParamUser($user_id)
      {
        $followCollectionOfUserIds = Follow::where('receive_user_id', $user_id)->pluck('send_user_id');

        $userIdsArray = [];
        foreach($followCollectionOfUserIds as $user_id)
        {
          $userIdsArray[] = $user_id;
        }

        return $userIdsArray;
      
      }
}
