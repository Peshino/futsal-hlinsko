<?php

use App\Team;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/teams.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Team::create([
                'name' => $object->name,
                'name_short' => $object->name_short,
                'history_code' => time() . '_' . random_int(10000, 99999),
                'web_presentation' => $object->web_presentation,
                'primary_color_id' => $object->primary_color_id,
                'secondary_color_id' => $object->secondary_color_id,
                'user_id' => $object->user_id,
                'competition_id' => $object->competition_id,
            ]);
        }
    }
}
