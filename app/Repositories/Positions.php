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

    public function getPositionsFiltered(Competition $competition = null, Rule $rule = null, Team $team = null, $position = null, $round = null, $toRound = null, $order = 'asc', $limit = null)
    {
        $result = null;
        $query = Position::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }

        if ($team !== null) {
            $query = $query->where('team_id', $team->id);
        }

        if ($position !== null) {
            $query = $query->where('position', $position);
        }

        if ($round !== null) {
            $query = $query->where('round', $round);
        }

        if ($toRound !== null) {
            $query = $query->where('round', '<=', $toRound);
        }

        $result = $query->orderBy('position', $order)->limit($limit)->get();

        if (count($result) === 1) {
            return $result[0];
        }

        return $result;
    }

    public function synchronize(Competition $competition = null, Rule $rule = null)
    {
        $gamesRepository = new Games;

        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results', 'asc');

        if (!empty($rounds)) {
            foreach ($rounds as $round) {
                $toRound = $round;
                $tableData = $gamesRepository->getTableData($competition, $rule, $toRound, true, true, true);

                if (!empty($tableData)) {
                    foreach ($tableData as $key => $tableItem) {
                        $positionValue = $key + 1;
                        $positions = $this->getPositionsFiltered($competition, $rule, null, $positionValue, $round);

                        if ($positions instanceof Position) {
                            $position = $positions;
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
        }

        return true;
    }

    public function getTeamCurrentPosition(Competition $competition, Rule $rule, Team $team, $round)
    {
        $teamCurrentPosition = null;

        if (isset($round) && !empty($round)) {
            $position = $this->getPositionsFiltered($competition, $rule, $team, null, $round);

            $teamCurrentPosition = isset($position->position) && !empty($position->position) ? $position->position : null;
        }

        return $teamCurrentPosition;
    }

    public function getTeamPreviousPosition(Competition $competition, Rule $rule, Team $team, $round)
    {
        $teamPreviousPosition = null;

        if (isset($round) && !empty($round)) {
            $round = (int) $round;

            if ($round > 1) {
                $round -= 1;

                $teamPreviousPosition = $this->getTeamCurrentPosition($competition, $rule, $team, $round);
            }
        }

        return $teamPreviousPosition;
    }
}
