<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DatabaseSeeder;


class FindControllerTest extends TestCase
{

    
    /** @test index */
    function ゲストはページを表示出来ない()
    {
        
        $url = 'login';

        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();

        $this->get(route('finds.index'))->assertRedirect($url);
    }


    /** @test index */
    function findsのindexを表示できる()
    {

        $this->seed(DatabaseSeeder::class);

        $user = $this->loginUser();
        
        $this->get(route('finds.index'))
            ->assertOk()
            ->assertSee('年代')
            ->assertSee('所属チーム');
    }






    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
}
