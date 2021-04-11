<?php

use App\Competition;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/competitions.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Competition::create([
                'name' => $object->name,
                'status' => $object->status,
                'user_id' => $object->user_id,
                'season_id' => $object->season_id,
                'competition_style_id' => $object->competition_style_id,
            ]);
        }
    }
}
