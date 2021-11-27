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
        $seedFromOldDb = config('app.seed_from_old_db');

        $json = File::get('database/data/' . ($seedFromOldDb ? 'oldDB/' : '') . 'rules.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Rule::create([
                'name' => $object->name,
                'type' => $object->type,
                'system' => $object->system,
                'apply_mutual_balance' => $object->apply_mutual_balance,
                'priority' => $object->priority,
                'number_of_rounds' => $object->number_of_rounds,
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
