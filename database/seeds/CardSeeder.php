<?php

use App\Card;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/cards.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Card::create([
                'yellow' => $object->yellow,
                'red' => $object->red,
                'player_id' => $object->player_id,
                'team_id' => $object->team_id,
                'game_id' => $object->game_id,
                'user_id' => $object->user_id,
                'rule_id' => $object->rule_id,
                'competition_id' => $object->competition_id,
            ]);
        }
    }
}
