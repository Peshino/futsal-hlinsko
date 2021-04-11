<?php

use App\Goal;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/goals.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Goal::create([
                'amount' => $object->amount,
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
