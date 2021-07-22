<?php

namespace App\packages\Infrastructure\Era;


// use Illuminate\Support\Facades\DB;
use App\packages\Domain\Domain\Era\Era;
// use packages\Domain\Domain\User\UserId;
use App\packages\Domain\Domain\Era\EraRepositoryInterface;
// use Illuminate\Support\Facades\Auth;
// use App\User as UserModel;
use App\Era as EraModel;
use Carbon\Carbon;

class EraRepository implements EraRepositoryInterface
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
     * @param int $user_id
     * @return Era
     */
    public function getEraArrayEqualUserId(int $user_id)
    {
        // $user = UserModel::where('id', Auth::id())->first();
        $eras = EraModel::where('id', $user_id)->get();
        // ↑  後でorderByを付け足す！

        // return new User($user->id, $user->name, $user->email, $user->user_name, $user->age, $user->image, $user->introduction, $user->area_id, (new Carbon($user->created_at))->toDateTimeString(), (new Carbon($user->updated_at))->toDateTimeString());
        $eraEntityArray = [];
        foreach($eras as $era)
        {
          $eraEntityArray[] = new Era($era->id, $era->user_id, $era->position_id, $era->team_id, $era->era_id, (new Carbon($era->created_at))->toDateTimeString(), (new Carbon($era->updated_at))->toDateTimeString());
        }
    }

}
