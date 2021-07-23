<?php

namespace App\packages\Infrastructure\Talk;


// use Illuminate\Support\Facades\DB;
use App\packages\Domain\Domain\Talk\Talk;
// use packages\Domain\Domain\User\UserId;
use App\packages\Domain\Domain\Talk\TalkRepositoryInterface;
// use Illuminate\Support\Facades\Auth;
// use App\User as UserModel;
use App\Talk as TalkModel;
use Carbon\Carbon;

class TalkRepository implements TalkRepositoryInterface
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
    
}
