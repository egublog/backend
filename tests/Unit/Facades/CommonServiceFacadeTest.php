<?php

namespace Tests\Unit\Facades;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;
use App\All;
use App\Talk;
use App\Talk_list;
use Illuminate\Support\Collection;
use App\User;
use App\Follow;
use Illuminate\Support\Str;
use App\Facades\CommonService;


class CommonServiceFacadeTest extends TestCase
{


    /** @test reverseCollection */
    function reverseCollectionメソッドで引数のコレクションの中身を逆にする()
    {

        $asc = [1, 2, 3, 4, 5];
        $desc = [5, 4, 3, 2, 1];
        $ascCollection = collect($asc);
        $descCollection = collect($desc);

        $collection = CommonService::reverseCollection($ascCollection);

        // dd($ascCollection, $collection);

        $this->assertEquals($descCollection, $collection);
    }



    // /**
    //  * A basic unit test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }
}
