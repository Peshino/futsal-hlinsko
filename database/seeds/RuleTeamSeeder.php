<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class RuleTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
