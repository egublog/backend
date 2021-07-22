<?php

namespace App\packages\Domain\Domain\User;

// use DateTime;
// use Illuminate\Support\Collection;
// use App\packages\Domain\Common\All\All;


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
// ↑  本来は厳密にクリーンアーキテクチャをやろうとしたら、このカラムを全てエンティティしてやる


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
     * @var string
     */
    private $area_id;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;
    
    // /**
    //  * @var array
    //  */
    // private $alls = [];

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
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(int $id, string $name, string $email, ?string $user_name, ?int $age, ?string $image, ?string $introduction, int $area_id, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->user_name = $user_name;
        $this->age = $age;
        $this->image = $image;
        $this->introduction = $introduction;
        // $this->area_id = $this->changeAreaIdToPrefecturesName($area_id);
        $this->area_id = $this->$area_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        // foreach($alls as $all) {
        //   $this->alls[] = new All($all->id, $all->user_id, $all->position_id, $all->team_id, $all->era_id, $all->created_at, $all->updated_at, $all->team);
        // }
        // ↑ ここにはロジックを書かない方がいい
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

       
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

       
    /**
     * @return string
     */
    public function getUser_name(): ?string
    {
        return $this->user_name;
    }

    /**
     * @return int
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

       
    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

       
    /**
     * @return string
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

       
    /**
     * @return string
     */
    public function getArea_id(): string
    {
        return $this->area_id;
    }

       
    /**
     * @return string
     */
    public function getCreated_at(): string
    {
        return $this->created_at;
    }

       
    /**
     * @return string
     */
     public function getUpdated_at(): string
     {
         return $this->updated_at;
     }
 
    
}
