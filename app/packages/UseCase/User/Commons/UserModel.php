<?php

namespace App\packages\UseCase\User\Commons;

use DateTime;
// use Illuminate\Support\Collection;
// use App\packages\Domain\Common\All\All;
// use Illuminate\Support\Arr;


class UserModel
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
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
    
    /**
     * @var array
     */
    public $alls;

    /**
     * User constructor.
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $user_name
     * @param int $age
     * @param string $image
     * @param string $introduction
     * @param string $area_id
     * @param string $created_at
     * @param string $updated_at
     * @param array $alls
     */
    public function __construct(int $id, string $name, string $email, ?string $user_name, ?int $age, ?string $image, ?string $introduction, string $area_id, string $created_at, string $updated_at, array $alls)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->user_name = $user_name;
        $this->age = $age;
        $this->image = $image;
        $this->introduction = $introduction;
        $this->area_id = $this->area_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->alls = $alls;

        // foreach($alls as $all) {
        //   $this->alls[] = new All($all->id, $all->user_id, $all->position_id, $all->team_id, $all->era_id, $all->created_at, $all->updated_at, $all->team);
        // }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

       
    
}
