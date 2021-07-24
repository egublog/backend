<?php

namespace App\Http\Models\User\Commons;


// use DateTime;
// use Illuminate\Support\Collection;
// use App\packages\Domain\Common\All\All;
// use Illuminate\Support\Arr;


class UserViewModel
{

    // ↓　　これはUserIdのインスタンスって事　なんでこれはわざわざUserのidをインスタンス化しているのか
    // 　　　　　直で stringで指定するとなんか使いにくいのか？　拡張しにくいのか？
    // 　　　　　UserId専用のメソッドとかを作れると言うことは分かる、ただ遠回りになる気がする。
    // 　　　　　　ではなぜ $nameの方はこのままクラスを作らずに直でこうなっているのか？  (idはなんかロジックを変更する可能性が高いからか？)
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $user_name;

    /**
     * @var int
     */
    public $age;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $introduction;

    /**
     * @var int
     */
    public $area_id;

    /**
     * @var string
     */
    public $area_name;

    /**
     * @var array
     */
    public $eras;

    /**
     * User constructor.
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $user_name
     * @param int $age
     * @param string $image
     * @param string $introduction
     * @param int $area_id
     * @param string $area_name
     * @param array $eras
     */
    public function __construct(int $id, string $name, string $email, ?string $user_name, ?int $age, ?string $image, ?string $introduction, int $area_id, string $area_name, array $eras)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->user_name = $user_name;
        $this->age = $age;
        $this->image = $image;
        $this->introduction = $introduction;
        $this->area_id = $area_id;
        $this->area_name = $area_name;
        $this->eras = $eras;

        // foreach($alls as $all) {
        //   $this->alls[] = new All($all->id, $all->user_id, $all->position_id, $all->team_id, $all->era_id, $all->created_at, $all->updated_at, $all->team);
        // }
    }

    // /**
    //  * @return int
    //  */
    // public function getId(): int
    // {
    //     return $this->id;
    // }

    // /**
    //  * @return string
    //  */
    // public function getName(): string
    // {
    //     return $this->name;
    // }

       
    
}
