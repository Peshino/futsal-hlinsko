<?php

use App\Season;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/seasons.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Season::create([
                'name' => $object->name,
                'user_id' => $object->user_id,
            ]);
        }
    }
}
