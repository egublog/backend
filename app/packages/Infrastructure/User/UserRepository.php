<?php

namespace App\packages\Infrastructure\User;


// use Illuminate\Support\Facades\DB;
use App\packages\Domain\Domain\User\User;
// use packages\Domain\Domain\User\UserId;
use App\packages\Domain\Domain\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\User as UserModel;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface
{
    // /**
    //  * @param User $user
    //  * @return mixed
    //  */
    // public function save(User $user)
    // {
    //     // なんでここでDBから取得しているのか、エロクエントを使わずに(getじゃなくてsaveだったら取得する値とかあまり考える必要が無いからエロークエントでもいいのではと思ってしまう)
    //     // 　　　　Illuminate\Database\Eloquent\Collectionはエロークエントで取得したやつ
    //     // 　　　　　　　↑　テーブルをPHPのクラス　レコードをクラスのインスタンス　フィールドをプロパティとして扱える
    //     // 　　　　Illuminate\Support\Collection  DB::table()->get(); とかのクエリビルダで取得したやつ
    //     // 　　　　　　　↑　ただデータベースのテーブルやレコードを連想配列に全てまとめてしまえ！となったもの
    //     // 　　　　Illuminate\Database\Query\Builder  これがただのDBクラス
    //     DB::table('users')
    //         ->updateOrInsert(
    //             ['id' => $user->getId()],
    //             ['name' => $user->getName()]
    //         );
    // }

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
     * @return User
     */
    public function getAuthUser()
    {
        $user = UserModel::where('id', Auth::id())->with('eras.team')->first();

        // dd($user->created_at);

        // dd((new Carbon($user->created_at))->toDateTimeString());


        return new User($user->id, $user->name, $user->email, $user->user_name, $user->age, $user->image, $user->introduction, $user->area_id, (new Carbon($user->created_at))->toDateTimeString(), (new Carbon($user->updated_at))->toDateTimeString(), $user->alls);
        // return new User($user->id, $user->name, $user->email, $user->user_name, $user->age, $user->image, $user->introduction, $user->area_id, (new Carbon($user->created_at))->toDateTimeString(), (new Carbon($user->updated_at))->toDateTimeString());
    }
}
