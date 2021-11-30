<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use App\Rule;

class RuleTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedFromOldDb = config('app.seed_from_old_db');

        if ($seedFromOldDb) {
            $rules = Rule::all();

            if ($rules->isNotEmpty()) {
                foreach ($rules as $key => $rule) {
                    $homeTeams = $rule->games->pluck('home_team_id')->toArray();
                    $awayTeams = $rule->games->pluck('away_team_id')->toArray();

                    $ruleTeamIds = array_unique(array_merge($homeTeams, $awayTeams));
                    $rule->teams()->sync($ruleTeamIds);
                }
            }
        } else {
            $json = File::get('database/data/ruleTeam.json');
            $objects = json_decode($json);
            foreach ($objects as $object) {
                DB::table('rule_team')->insert([
                    'rule_id' => $object->rule_id,
                    'team_id' => $object->team_id,
                ]);
            }
        }
    }
}
