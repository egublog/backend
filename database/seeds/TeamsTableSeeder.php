<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        DB::table('teams')->insert([
            'team_name'=>'未設定です。'
        ]);
        DB::table('teams')->insert([
            'team_name'=>'未所属'
        ]);
            
      
    }
}
