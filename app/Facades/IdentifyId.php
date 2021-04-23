<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class IdentifyId extends Facade 
{

  protected static function getFacadeAccessor()
  {
    return 'identifyid';
  }
}


