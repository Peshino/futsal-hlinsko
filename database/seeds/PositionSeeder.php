<?php

use Illuminate\Database\Seeder;
use App\Repositories\Positions;
use App\Competition;

class PositionSeeder extends Seeder
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
            $positionsRepository = new Positions;

            $competitions = Competition::all();

            if ($competitions->isNotEmpty()) {
                foreach ($competitions as $key => $competition) {
                    $competitionRules = $competition->rules;

                    if ($competitionRules->isNotEmpty()) {
                        foreach ($competitionRules as $key => $rule) {
                            $positionsRepository->synchronize($competition, $rule);
                        }
                    }
                }
            }
        }
    }
}
