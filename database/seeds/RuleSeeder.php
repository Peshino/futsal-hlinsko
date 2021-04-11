<?php

use App\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/rules.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Rule::create([
                'name' => $object->name,
                'system' => $object->system,
                'display_as' => $object->display_as,
                'priority' => $object->priority,
                'number_of_rounds' => $object->number_of_rounds,
                'number_of_qualifiers' => $object->number_of_qualifiers,
                'number_of_descending' => $object->number_of_descending,
                'game_duration' => $object->game_duration,
                'points_for_win' => $object->points_for_win,
                'games_day_min' => $object->games_day_min,
                'games_day_max' => $object->games_day_max,
                'team_games_day_round_min' => $object->team_games_day_round_min,
                'team_games_day_round_max' => $object->team_games_day_round_max,
                'game_days_times' => $object->game_days_times,
                'case_of_draw' => $object->case_of_draw,
                'start_date' => $object->start_date,
                'end_date' => $object->end_date,
                'break_start_date' => $object->break_start_date ?? null,
                'break_end_date' => $object->break_end_date ?? null,
                'user_id' => $object->user_id,
                'competition_id' => $object->competition_id,
            ]);
        }
    }
}
