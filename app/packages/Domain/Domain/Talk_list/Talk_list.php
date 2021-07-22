<?php

namespace App\packages\Domain\Domain\Talk_list;

// use DateTime;
// use Illuminate\Support\Arr;


class Talk_list
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $from;

    /**
     * @var int
     */
    private $to;

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
     * @param int $from
     * @param int $to
     * @param string $created_at
     * @param string $updated_at
     */

    public function __construct(int $id, int $from, int $to, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
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
    public function getFrom(): int
    {
        return $this->from;
    }
       
    
    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
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
