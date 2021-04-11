<?php

use App\CompetitionStyle;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class CompetitionStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/competitionStyles.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            CompetitionStyle::create([
                'name' => $object->name,
                'color_id' => $object->color_id,
            ]);
        }
    }
}
