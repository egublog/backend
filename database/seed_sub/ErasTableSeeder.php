<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ErasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('eras')->insert([
            'era_name'=>'小学校'
        ]);
        DB::table('eras')->insert([
            'era_name'=>'中学校'
        ]);
        DB::table('eras')->insert([
            'era_name'=>'高校'
        ]);
        DB::table('eras')->insert([
            'era_name'=>'大学'
        ]);
    }
}
