<?php

namespace App\packages\Domain\Domain\Follow;

// use DateTime;
// use Illuminate\Support\Arr;


class Follow
{

    /**
     * @var int
     */
    private $id;


    /**
     * @var int
     */
    private $send_user_id;


    /**
     * @var int
     */
    private $receive_user_id;


    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;
    

    /**
     * User constructor.
     * @param int $id
     * @param int $send_user_id
     * @param int $receive_user_id
     * @param string $created_at
     * @param string $updated_at
     */

    public function __construct(int $id, int $send_user_id, int $receive_user_id, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->send_user_id = $send_user_id;
        $this->receive_user_id = $receive_user_id;
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
     * @return int
     */
    public function getSend_user_id(): int
    {
        return $this->send_user_id;
    }
    

    /**
     * @return int
     */
     public function getReceive_user_id(): int
     {
         return $this->receive_user_id;
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
