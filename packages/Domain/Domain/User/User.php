<?php

namespace packages\Domain\Domain\User;

use DateTime;

class User
{

    // ↓　　これはUserIdのインスタンスって事　なんでこれはわざわざUserのidをインスタンス化しているのか
    // 　　　　　直で stringで指定するとなんか使いにくいのか？　拡張しにくいのか？
    // 　　　　　UserId専用のメソッドとかを作れると言うことは分かる、ただ遠回りになる気がする。
    // 　　　　　　ではなぜ $nameの方はこのままクラスを作らずに直でこうなっているのか？  (idはなんかロジックを変更する可能性が高いからか？)
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var int
     */
    private $age;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $introduction;

    /**
     * @var int
     */
    private $area_id;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;


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
     * @param DateTime $created_at
     * @param DateTime $updated_at
     */
    public function __construct(int $id, string $name, string $email, ?string $user_name, ?int $age, ?string $image, ?string $introduction, int $area_id, DateTime $created_at, DateTime $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->user_name = $user_name;
        $this->age = $age;
        $this->image = $image;
        $this->introduction = $introduction;
        $this->area_id = $area_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
