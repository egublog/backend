<?php

namespace App\MyClasses;

use App\All;


class CommonService
{

  public function reverseCollection($talkDatasDesc)
  {
    return $talkDatasDesc->reverse()->values();
  }

}