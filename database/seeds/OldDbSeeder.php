<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::connection('mysql2')->select('SELECT * FROM `cards`');

        dd($users);
    }
}
