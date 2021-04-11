<?php

use App\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/roles.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Role::create([
                'name' => $object->name,
                'label' => $object->label,
            ]);
        }
    }
}
