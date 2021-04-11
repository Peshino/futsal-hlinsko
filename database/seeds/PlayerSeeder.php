<?php

use App\Player;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/players.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Player::create([
                'firstname' => $object->firstname,
                'lastname' => $object->lastname,
                'history_code' => time() . '_' . random_int(10000, 99999),
                'jersey_number' => $object->jersey_number,
                'birthdate' => $object->birthdate,
                'position' => $object->position,
                'height' => $object->height,
                'nationality' => $object->nationality,
                'team_id' => $object->team_id,
                'user_id' => $object->user_id,
                'competition_id' => $object->competition_id,
            ]);
        }
    }
}
