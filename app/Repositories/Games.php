<?php

namespace App\Repositories;

use App\Season;
use App\Game;
use App\Competition;
use App\Rule;
use App\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Games
{
    public function __construct()
    {
    }

    public function all()
    {
        return Game::all();
    }

    public function getLastRecord()
    {
        $record = Game::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getGamesFiltered(Competition $competition = null, Rule $rule = null, Team $team = null, $gamesStatus = 'all', $round = null, $toRound = null, $gamesFormCount = null, $order = 'desc')
    {
        $query = Game::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }

        if ($round !== null) {
            $query = $query->where('round', $round);
        }

        if ($toRound !== null) {
            $query = $query->where('round', '<=', $toRound);
        }

        if ($team !== null) {
            $query = $query->where(function ($query) use ($team) {
                $query->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
            });
        }

        switch ($gamesStatus) {
            case 'results':
                if ($rule !== null) {
                    $query = $query->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $rule->game_duration . ' MINUTE) <= NOW()');
                } else {
                    $query = $query->where('start_datetime', '<=', Carbon::now());
                }

                $query = $query->whereNotNull('home_team_score');
                $query = $query->whereNotNull('away_team_score');
                break;
            case 'schedule':
                if ($rule !== null) {
                    $query = $query->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $rule->game_duration . ' MINUTE) > NOW()');
                } else {
                    $query = $query->where('start_datetime', '>', Carbon::now());
                }
                break;
            case 'all':
                break;
            default:
        }

        if ($gamesFormCount !== null) {
            $query = $query->take($gamesFormCount);
        }

        return $query->orderBy('start_datetime', $order)->get();
    }

    public function getRoundsFiltered(Competition $competition = null, Rule $rule = null, $gamesStatus = null, $order = 'desc')
    {
        $rounds = [];
        $games = $this->getGamesFiltered($competition, $rule, null, $gamesStatus, null, $order);

        if ($games !== null) {
            $gamesRounds = collect($games)->unique('round')->values();

            if ($gamesRounds !== null) {
                foreach ($gamesRounds as $gamesRound) {
                    $rounds[] = $gamesRound->round;
                }
            }
        }

        return $rounds;
    }

    public function getTableData(Competition $competition, Rule $rule, $toRound = null, $orderByGoalDifference = false, $orderByGoalsScored = false, $teams = [])
    {
        $implodedTeams = null;

        if (!empty($teams) && is_array($teams)) {
            $implodedTeams = implode(', ', $teams);
        }

        $tableData = DB::select(
            'SELECT
                team_id,
                teams.name team_name,
                COUNT(*) games_count,
                COUNT(CASE WHEN home_team_score > away_team_score THEN 1 END) wins,
                COUNT(CASE WHEN home_team_score = away_team_score THEN 1 END) draws,
                COUNT(CASE WHEN away_team_score > home_team_score THEN 1 END) losts,
                SUM(home_team_score) team_goals_scored,
                SUM(away_team_score) team_goals_received,
                SUM(home_team_score) - SUM(away_team_score) team_goals_difference,
                SUM(CASE WHEN home_team_score > away_team_score THEN ? ELSE 0 END + CASE WHEN home_team_score = away_team_score THEN 1 ELSE 0 END) points
            FROM
                (
                SELECT
                    home_team_id team_id,
                    home_team_score,
                    away_team_score
                FROM
                    games
                WHERE
                    competition_id = ? AND rule_id = ? AND ROUND <= ? AND start_datetime <= NOW() AND home_team_score IS NOT NULL AND away_team_score IS NOT NULL
                    ' . ($implodedTeams !== null ? ' AND home_team_id IN (' . $implodedTeams . ') AND away_team_id IN (' . $implodedTeams . ')' : '') . '
                UNION ALL
            SELECT
                away_team_id,
                away_team_score,
                home_team_score
            FROM
                games
            WHERE
                competition_id = ? AND rule_id = ? AND ROUND <= ? AND start_datetime <= NOW() AND away_team_score IS NOT NULL AND home_team_score IS NOT NULL
                ' . ($implodedTeams !== null ? ' AND away_team_id IN (' . $implodedTeams . ') AND home_team_id IN (' . $implodedTeams . ')' : '') . '
            ) a
            INNER JOIN Teams ON teams.id = a.team_id
            GROUP BY
                team_id,
                team_name
            ORDER BY
                points DESC
                ' . ($orderByGoalDifference ? ', team_goals_difference DESC' : '') . '
                ' . ($orderByGoalsScored ? ', team_goals_scored DESC' : '') . ' ;
            ',
            array($rule->points_for_win, $competition->id, $rule->id, $toRound, $competition->id, $rule->id, $toRound)
        );

        return $tableData;
    }

    public function getMiniTablesData($tableData)
    {
        $miniTablesData = [];

        if (!empty($tableData)) {
            foreach ($tableData as $tableTeamData) {
                $miniTablesData[$tableTeamData->points][] = $tableTeamData;
            }

            return $miniTablesData;
        }

        return null;
    }

    public function getOrderedMiniTables($miniTablesData, Competition $competition, Rule $rule, $toRound = null, $orderByGoalDifference = false, $orderByGoalsScored = false)
    {
        $orderedMiniTables = [];

        if (!empty($miniTablesData)) {
            foreach ($miniTablesData as $points => $miniTableData) {
                $teams = array_column($miniTableData, 'team_id');
                $orderedMiniTables[$points] = $this->getTableData($competition, $rule, $toRound, $orderByGoalDifference, $orderByGoalsScored, $teams);
            }

            return $orderedMiniTables;
        }

        return null;
    }

    public function getTableDataWithMiniTablesApplied($miniTablesData, $orderedMiniTables)
    {
        $tableData = [];

        if (!empty($miniTablesData) && !empty($orderedMiniTables)) {
            foreach ($miniTablesData as $points => $miniTableData) {
                if (count($miniTableData) > 1) {
                    if (array_multisort($miniTableData, $orderedMiniTables[$points])) {
                        $tableData[$points] = $miniTableData;
                    } else {
                        return false;
                    }
                } else {
                    $tableData[$points] = $miniTableData;
                }
            }

            return array_merge(...$tableData);
        }

        return null;
    }
}
