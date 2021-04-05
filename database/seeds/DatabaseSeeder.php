<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(ErasTableSeeder::class);
        $this->call(AreasTableSeeder::class);
    }
}
