<?php

namespace App\packages\Domain\Domain\User;

use DateTime;
use Illuminate\Support\Collection;
use App\packages\Domain\Common\All\All;
use Illuminate\Support\Arr;


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
    
    /**
     * @var array
     */
    private $alls = [];

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
     * @param Collection $alls
     */
    public function __construct(int $id, string $name, string $email, ?string $user_name, ?int $age, ?string $image, ?string $introduction, int $area_id, string $created_at, string $updated_at, Collection $alls)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->user_name = $user_name;
        $this->age = $age;
        $this->image = $image;
        $this->introduction = $introduction;
        $this->area_id = $this->changeAreaIdToPrefecturesName($area_id);
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        foreach($alls as $all) {
          $this->alls[] = new All($all->id, $all->user_id, $all->position_id, $all->team_id, $all->era_id, $all->created_at, $all->updated_at, $all->team);
        }
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
 
       
       
    /**
     * @return array
     */
    public function getAlls(): array
    {
        return $this->alls;
    }

        
       
    public function changeAreaIdToPrefecturesName($value)
    {
        $prefs = [
            '1' => '北海道',
            '2' => '青森県',
            '3' => '岩手県',
            '4' => '宮城県',
            '5' => '秋田県',
            '6' => '山形県',
            '7' => '福島県',
            '8' => '茨城県',
            '9' => '栃木県',
            '10' => '群馬県',
            '11' => '埼玉県',
            '12' => '千葉県',
            '13' => '東京都',
            '14' => '神奈川県',
            '15' => '新潟県',
            '16' => '富山県',
            '17' => '石川県',
            '18' => '福井県',
            '19' => '山梨県',
            '20' => '長野県',
            '21' => '岐阜県',
            '22' => '静岡県',
            '23' => '愛知県',
            '24' => '三重県',
            '25' => '滋賀県',
            '26' => '京都府',
            '27' => '大阪府',
            '28' => '兵庫県',
            '29' => '奈良県',
            '30' => '和歌山県',
            '31' => '鳥取県',
            '32' => '島根県',
            '33' => '岡山県',
            '34' => '広島県',
            '35' => '山口県',
            '36' => '徳島県',
            '37' => '香川県',
            '38' => '愛媛県',
            '39' => '高知県',
            '40' => '福岡県',
            '41' => '佐賀県',
            '42' => '長崎県',
            '43' => '熊本県',
            '44' => '大分県',
            '45' => '宮崎県',
            '46' => '鹿児島県',
            '47' => '沖縄県',
            '48' => '海外',
            '49' => 'その他',
            '50' => '未設定です',
        ];

        if($value === null)
        {
            return $value;
        }

        return Arr::get($prefs, $value);
    }
}
