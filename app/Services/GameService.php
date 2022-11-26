<?php

namespace App\Services;

use App\Competition;
use App\Rule;
use App\Team;
use App\Repositories\Games;
use App\Repositories\Positions;
// use Illuminate\Support\Facades\Cache;

class GameService
{
    public function getTableData(Competition $competition, Rule $rule, $toRound = null, $simpleData = false)
    {
        $toRound = $toRound ?? rand(9999, 99999);

        // if (Cache::has('table-data-' . $competition->id . '-' . $rule->id . '-' . $toRound)) {
        //     $tableData = Cache::get('table-data-' . $competition->id . '-' . $rule->id . '-' . $toRound);
        // } else {
        $gamesRepository = new Games;

        $synchronizePositions = false;
        $currentRound = $toRound ?? null;
        $tableData = $gamesRepository->getTableData($competition, $rule, $toRound, true, true);

        if (!$simpleData) {
            $positionsRepository = new Positions;

            $phases = $rule->phases;
            $phasesOrder = [
                'qualification' => [],
                'descent' => [],
            ];
            $fromToPhases = $phases->map->only(['from_position', 'to_position']);

            if (!empty($tableData)) {
                foreach ($tableData as $tablePosition => $tableItem) {
                    $team = Team::find($tableItem->team_id);
                    $teamForm = $gamesRepository->getTeamForm($competition, $team, $rule, $toRound);
                    $teamFirstSchedule = $gamesRepository->getTeamFirstSchedule($competition, $team, $rule);

                    $teamCurrentPosition = $positionsRepository->getTeamCurrentPosition($competition, $rule, $team, $currentRound);
                    $teamPreviousPosition = $positionsRepository->getTeamPreviousPosition($competition, $rule, $team, $currentRound);

                    if ($teamCurrentPosition === null || $teamPreviousPosition === null) {
                        $synchronizePositions = true;
                    }

                    $teamCurrentPosition = $teamCurrentPosition ?? ($tablePosition + 1);

                    if (!empty($fromToPhases)) {
                        foreach ($fromToPhases as $key => $fromToPhase) {
                            $fromPosition = $fromToPhase['from_position'];
                            $toPosition = $fromToPhase['to_position'];

                            if ($teamCurrentPosition >= $fromPosition && $teamCurrentPosition <= $toPosition) {
                                $teamPhase = $phases[$key];

                                if (!in_array($teamPhase->id, $phasesOrder[$teamPhase->phase])) {
                                    $phasesOrder[$teamPhase->phase][] = $teamPhase->id;
                                }

                                $teamPhase->order = array_search($teamPhase->id, $phasesOrder[$teamPhase->phase]);

                                $tableItem->team_phase = $teamPhase;
                                break;
                            }
                        }
                    }

                    $tableItem->team_form = $teamForm;
                    $tableItem->team_first_schedule = $teamFirstSchedule;
                    $tableItem->team_current_position = $teamCurrentPosition;
                    $tableItem->team_previous_position = $teamPreviousPosition;
                }
            }

            if ($synchronizePositions) {
                $positionsRepository->synchronize($competition, $rule);
            }
        }

        //     Cache::put('table-data-' . $competition->id . '-' . $rule->id . '-' . $toRound, $tableData);
        // }

        return $tableData;
    }
}
