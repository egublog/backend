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
            'position'=>'GK'
        ]);
        
        DB::table('positions')->insert([
            'position'=>'DF'
        ]);
        
        DB::table('positions')->insert([
            'position'=>'MF'
        ]);
        
        DB::table('positions')->insert([
            'position'=>'FW'
        ]);
    }
}
