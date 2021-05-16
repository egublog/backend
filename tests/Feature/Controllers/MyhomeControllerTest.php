<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\All;
use DatabaseSeeder;

class MyhomeControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test index */
    function ゲストはmyhomesのページを表示出来ない()
    {
        $url = 'login';
        
        $this->seed(DatabaseSeeder::class);

        $user = $this->notLoginUser();
        $this->get(route('myhomes.index'))
            ->assertRedirect($url);
    }

    /** @test index */
    function myhomesのindexページを表示できる()
    {

        $this->withoutExceptionHandling();

        $this->seed(DatabaseSeeder::class);
        // $user = factory(User::class)->create()->alls()->createMany(

        //     factory(All::class, 4)->create([
        //         'era_id' => 1,
        //     ])
        // );
        // $user = factory(User::class)->create();

        // for ($i = 1; $i < 5; $i++) {
        //     factory(All::class)->create([
        //         'user_id' => $user->id,
        //         'era_id' => $i,
        //     ]);
        // }

        $user = $this->loginUser();

        $this->actingAs($user)->get(route('myhomes.index'))->assertOk();
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
