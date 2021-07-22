<?php

namespace App\packages\Domain\Domain\Talk;

// use DateTime;
// use Illuminate\Support\Arr;


class Talk
{

    /**
     * @var int
     */
    private $id;


    /**
     * @var string
     */
    private $talk_data;

    /**
     * @var int
     */
     private $from;

    
    /**
     * @var int
     */
     private $to;

    
    /**
     * @var boolean
     */
     private $yet;

    
    
    /**
     * @var boolean
     */
     private $talkCheck;

    

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
     * @param string $talk_data
     * @param int $from
     * @param int $to
     * @param boolean $yet
     * @param boolean $talkCheck
     * @param string $created_at
     * @param string $updated_at
     */

    public function __construct(int $id, string $talk_data, int $from, int $to, boolean $yet, boolean $talkCheck, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->talk_data = $talk_data;
        $this->from = $from;
        $this->to = $to;
        $this->yet = $yet;
        $this->talkCheck = $talkCheck;
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
    public function getTalk_data(): string
    {
        return $this->talk_data;
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
     * @return boolean
     */
     public function getYet(): boolean
     {
         return $this->yet;
     }
 
    
    /**
     * @return boolean
     */
     public function getTalkCheck(): boolean
     {
         return $this->talkCheck;
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
