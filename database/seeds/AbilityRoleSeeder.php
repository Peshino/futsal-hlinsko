<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class AbilityRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/abilityRole.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            DB::table('ability_role')->insert([
                'role_id' => $object->role_id,
                'ability_id' => $object->ability_id,
            ]);
        }
    }
}
