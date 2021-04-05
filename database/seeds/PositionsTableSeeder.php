<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('positions')->insert([
            'position_name'=>'GK'
        ]);
        
        DB::table('positions')->insert([
            'position_name'=>'DF'
        ]);
        
        DB::table('positions')->insert([
            'position_name'=>'MF'
        ]);
        
        DB::table('positions')->insert([
            'position_name'=>'FW'
        ]);
    }
}
