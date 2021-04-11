<?php

use App\Ability;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/abilities.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Ability::create([
                'name' => $object->name,
                'label' => $object->label,
            ]);
        }
    }
}
