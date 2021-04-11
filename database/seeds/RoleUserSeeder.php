<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/roleUser.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            DB::table('role_user')->insert([
                'user_id' => $object->user_id,
                'role_id' => $object->role_id,
            ]);
        }
    }
}
