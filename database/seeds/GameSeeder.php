<?php

use App\Game;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/games.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Game::create([
                'round' => $object->round,
                'start_datetime' => $object->start_datetime,
                'home_team_id' => $object->home_team_id,
                'away_team_id' => $object->away_team_id,
                'home_team_score' => $object->home_team_score,
                'away_team_score' => $object->away_team_score,
                'home_team_halftime_score' => $object->home_team_halftime_score,
                'away_team_halftime_score' => $object->away_team_halftime_score,
                'user_id' => $object->user_id,
                'rule_id' => $object->rule_id,
                'competition_id' => $object->competition_id,
            ]);
        }
    }
}
