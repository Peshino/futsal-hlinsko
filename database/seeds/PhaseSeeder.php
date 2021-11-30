<?php

use App\Phase;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedFromOldDb = config('app.seed_from_old_db');

        $json = File::get('database/data/' . ($seedFromOldDb ? 'oldDB/' : '') . 'phases.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Phase::create([
                'from_position' => $object->from_position,
                'to_position' => $object->to_position,
                'phase' => $object->phase,
                'to_rule_id' => $object->to_rule_id,
                'rule_id' => $object->rule_id,
                'user_id' => $object->user_id,
                'competition_id' => $object->competition_id,
            ]);
        }
    }
}
