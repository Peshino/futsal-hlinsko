<?php

namespace App\Repositories;

use App\Position;
use App\Game;
use App\Competition;
use App\Rule;
use App\Team;
use App\Repositories\Games;

class Positions
{
    public function __construct()
    {
    }

    public function all()
    {
        return Position::all();
    }

    public function getLastRecord()
    {
        $record = Position::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getPositionsFiltered(Competition $competition = null, Rule $rule = null, $position = null, $round = null, $order = 'asc')
    {
        $query = Position::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }

        if ($position !== null) {
            $query = $query->where('position', $position);
        }

        if ($round !== null) {
            $query = $query->where('round', $round);
        }

        return $query->orderBy('position', $order)->get();
    }

    public function synchronize(Competition $competition = null, Rule $rule = null)
    {
        $gamesRepository = new Games;

        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results', 'asc');
        if (!empty($rounds)) {
            foreach ($rounds as $round) {
                $toRound = $round;
                $tableData = $gamesRepository->getTableData($competition, $rule, $toRound, true, true, null, true);

                if (!empty($tableData)) {
                    foreach ($tableData as $key => $tableItem) {
                        $positionValue = $key + 1;
                        $positions = $this->getPositionsFiltered($competition, $rule, $positionValue, $round);

                        if (count($positions) === 1) {
                            $position = Position::find($positions[0]->id);
                            $position->team_id = $tableItem->team_id;
                            $position->save();
                        } elseif (count($positions) > 1) {
                            return false;
                        } else {
                            $position = new Position;
                            $position->position = $positionValue;
                            $position->team_id = $tableItem->team_id;
                            $position->round = $round;
                            $position->rule_id = $rule->id;
                            $position->competition_id = $competition->id;
                            $position->save();
                        }
                    }
                } else {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
