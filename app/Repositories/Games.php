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

    public function getGamesFiltered(Competition $competition = null, Rule $rule = null, Team $team = null, $gamesStatus = 'all', $round = null, $toRound = null, $gamesFormCount = null, $order = null, $limit = null)
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
                if ($order === null) {
                    $order = 'desc';
                }

                if (auth()->user() !== null && auth()->user()->can('crud_games')) {
                    if ($rule !== null) {
                        $query = $query->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $rule->game_duration . ' MINUTE) <= NOW()');
                    } else {
                        $query = $query->where('start_datetime', '<=', Carbon::now());
                        $query = $query->whereNotNull('home_team_score');
                        $query = $query->whereNotNull('away_team_score');
                    }
                } else {
                    $query = $query->whereNotNull('home_team_score');
                    $query = $query->whereNotNull('away_team_score');
                }

                break;
            case 'schedule':
                $query = $query->whereNull('home_team_score');
                $query = $query->whereNull('away_team_score');

                if ($order === null) {
                    $order = 'asc';
                }

                if ($rule !== null) {
                    $query = $query->whereRaw('DATE_ADD(`start_datetime`, INTERVAL 36 MINUTE) > NOW()');
                } else {
                    $query = $query->where('start_datetime', '>', Carbon::now());
                }
                break;
            case 'schedule-from-now':
                $query = $query->whereNull('home_team_score');
                $query = $query->whereNull('away_team_score');

                if ($order === null) {
                    $order = 'asc';
                }

                $query = $query->where('start_datetime', '>', Carbon::now());
                break;
            case 'all':
                if ($order === null) {
                    $order = 'asc';
                }

                break;
            default:
                if ($order === null) {
                    $order = 'asc';
                }
        }

        if ($gamesFormCount !== null) {
            $limit = $gamesFormCount;
            $query = $query->take($gamesFormCount);
        }

        return $query->orderBy('start_datetime', $order)->limit($limit)->get();
    }

    public function getRoundsFiltered(Competition $competition = null, Rule $rule = null, $gamesStatus = null, $order = 'desc')
    {
        $rounds = [];
        $games = $this->getGamesFiltered($competition, $rule, null, $gamesStatus, null, null, null, $order);

        if ($games !== null) {
            $gamesRounds = collect($games)->unique('round')->sortDesc()->values();

            if ($gamesRounds !== null) {
                foreach ($gamesRounds as $gamesRound) {
                    $rounds[] = $gamesRound->round;
                }
            }
        }

        return $rounds;
    }

    public function getTableData(Competition $competition, Rule $rule, $toRound = null, $orderByGoalDifference = false, $orderByGoalsScored = false, $useSimpleTable = false)
    {
        $tableData = $this->getTableDataSql($competition, $rule, $toRound, $orderByGoalDifference, $orderByGoalsScored, [], $useSimpleTable);

        // Apply mini tables to rewrite the table data after mutual games have been played and if mutual balance is applied
        if ($rule->isAppliedMutualBalance()) {
            $miniTablesData = $this->getMiniTablesData($tableData);
            $orderedMiniTables = $this->getOrderedMiniTables($miniTablesData, $competition, $rule, $toRound, $orderByGoalDifference, $orderByGoalsScored);
            $tableData = $this->getTableDataWithMiniTablesApplied($miniTablesData, $orderedMiniTables);
        }

        return $tableData;
    }

    public function getTeamForm(Competition $competition, Team $team, Rule $rule = null, $toRound = null, $gamesFormCount = 5, $order = 'desc')
    {
        $teamForm = $this->getGamesFiltered($competition, $rule, $team, 'results', null, $toRound, $gamesFormCount, $order);

        if (count($teamForm) > 0) {
            foreach ($teamForm as $game) {
                $gameResult = $game->getResultByTeamId($team->id);
                $game->result = $gameResult;
            }

            return $teamForm;
        }

        return null;
    }

    public function getLastPlayedRound(Competition $competition, Rule $rule)
    {
        $results = $this->getGamesFiltered($competition, $rule, null, 'results');

        if ($results->isNotEmpty()) {
            return $results->max('round');
        }

        return null;
    }

    public function getTeamLastPlayedRound(Competition $competition, Rule $rule, Team $team)
    {
        $results = $this->getGamesFiltered($competition, $rule, $team, 'results');

        if ($results->isNotEmpty()) {
            return $results->max('round');
        }

        return null;
    }

    public function getTeamFirstSchedule(Competition $competition, Team $team, Rule $rule = null)
    {
        $results = $this->getGamesFiltered($competition, $rule, $team, 'schedule', null, null, null, 'asc');

        if ($results->isNotEmpty()) {
            return $results->first();
        }

        return null;
    }

    private function getTableDataSql(Competition $competition, Rule $rule, $toRound = null, $orderByGoalDifference = false, $orderByGoalsScored = false, $teams = [], $useSimpleTable = false, $isAppliedMutualBalance = false)
    {
        $originalPositionCase = null;
        $implodedTeams = null;

        if ($toRound !== null) {
            $toRound = (int) $toRound;
        }

        if (!empty($teams) && is_array($teams)) {
            $originalPositionCase = 'CASE team_id';
            foreach ($teams as $originalPosition => $team) {
                $originalPositionCase .= ' WHEN ' . $team . ' THEN "' . $originalPosition . '"';
            }
            $originalPositionCase .= ' END AS original_position';

            $implodedTeams = implode(', ', $teams);
        }

        $toRound = $toRound === null ? 'NULL' : $toRound;

        $tableData = DB::select(
            'SELECT
                    b.team_id AS team_id,
                    b.team_name AS team_name,
                    b.team_name_short AS team_name_short,
                    ' . ($useSimpleTable === false ? '(b.wins + b.draws + b.losses) AS games_count,' : '') . '
                    ' . ($useSimpleTable === false ? 'b.wins AS wins,' : '') . '
                    ' . ($useSimpleTable === false ? 'b.draws AS draws,' : '') . '
                    ' . ($useSimpleTable === false ? 'b.losses AS losses,' : '') . '
                    b.team_goals_scored AS team_goals_scored,
                    b.team_goals_received AS team_goals_received,
                    b.team_goals_difference AS team_goals_difference,
                    b.points AS points
                    ' . ($useSimpleTable === false ? ', b.original_position AS original_position' : '') . '
                FROM
                    (
                    SELECT
                    teams.id AS team_id,
                    teams.name AS team_name,
                    teams.name_short AS team_name_short,
                    ' . ($useSimpleTable === false ? 'COALESCE(COUNT(CASE WHEN home_team_score > away_team_score THEN 1 END), 0) AS wins,' : '') . '
                    ' . ($useSimpleTable === false ? 'COALESCE(COUNT(CASE WHEN home_team_score = away_team_score THEN 1 END), 0) AS draws,' : '') . '
                    ' . ($useSimpleTable === false ? 'COALESCE(COUNT(CASE WHEN away_team_score > home_team_score THEN 1 END), 0) AS losses,' : '') . '
                    COALESCE(SUM(home_team_score), 0) AS team_goals_scored,
                    COALESCE(SUM(away_team_score), 0) AS team_goals_received,
                    COALESCE(SUM(home_team_score) - SUM(away_team_score), 0) AS team_goals_difference,
                    COALESCE(SUM(CASE WHEN home_team_score > away_team_score THEN ' . $rule->points_for_win . ' ELSE 0 END + CASE WHEN home_team_score = away_team_score THEN 1 ELSE 0 END), 0) AS points
                    ' . ($originalPositionCase !== null ? ', ' . $originalPositionCase : ($useSimpleTable === false ? ', NULL AS original_position' : '')) . '
                FROM
                (
                    SELECT
                        home_team_id AS team_id,
                        home_team_score,
                        away_team_score
                    FROM
                        games
                    WHERE
                    competition_id = ' . $competition->id . ' AND rule_id = ' . $rule->id . ' AND round <= ' . $toRound . ' AND start_datetime <= NOW() AND home_team_score IS NOT NULL AND away_team_score IS NOT NULL
                        ' . ($implodedTeams !== null ? ' AND home_team_id IN (' . $implodedTeams . ') AND away_team_id IN (' . $implodedTeams . ')' : '') . '
                    UNION ALL
                    SELECT
                        away_team_id,
                        away_team_score,
                        home_team_score
                    FROM
                        games
                    WHERE
                        competition_id = ' . $competition->id . ' AND rule_id = ' . $rule->id . ' AND round <= ' . $toRound . ' AND start_datetime <= NOW() AND away_team_score IS NOT NULL AND home_team_score IS NOT NULL
                        ' . ($implodedTeams !== null ? ' AND away_team_id IN (' . $implodedTeams . ') AND home_team_id IN (' . $implodedTeams . ')' : '') . '
                ) a
                ' . ($isAppliedMutualBalance ? 'INNER JOIN teams ON teams.id = a.team_id' : 'RIGHT JOIN teams ON teams.id = a.team_id WHERE teams.id IN (SELECT team_id FROM rule_team WHERE rule_id = ' . $rule->id . ')') . '
                GROUP BY
                    team_id,
                    team_name
                ORDER BY
                    points DESC
                    ' . ($orderByGoalDifference ? ', team_goals_difference DESC' : '') . '
                    ' . ($orderByGoalsScored ? ', team_goals_scored DESC' : '') . '
                    ' . ($originalPositionCase !== null ? ', original_position ASC' : '') . '
                    , team_name
                ) b
            ;'
        );

        return $tableData;
    }

    private function getMiniTablesData($tableData)
    {
        $miniTablesData = [];

        if (!empty($tableData)) {
            foreach ($tableData as $tableTeamData) {
                $miniTablesData[$tableTeamData->points][$tableTeamData->team_id] = $tableTeamData;
            }

            return $miniTablesData;
        }

        return null;
    }

    private function getOrderedMiniTables($miniTablesData, Competition $competition, Rule $rule, $toRound = null, $orderByGoalDifference = false, $orderByGoalsScored = false)
    {
        $orderedMiniTables = [];

        if (!empty($miniTablesData)) {
            foreach ($miniTablesData as $points => $miniTableData) {
                $teams = array_column($miniTableData, 'team_id');
                $orderedMiniTables[$points] = $this->getTableDataSql($competition, $rule, $toRound, $orderByGoalDifference, $orderByGoalsScored, $teams, false, true);
            }

            return $orderedMiniTables;
        }

        return null;
    }

    private function getTableDataWithMiniTablesApplied($miniTablesData, $orderedMiniTables)
    {
        $tableData = [];

        if (!empty($miniTablesData) && !empty($orderedMiniTables)) {
            foreach ($miniTablesData as $points => $miniTableData) {
                $miniTableOrder = $orderedMiniTables[$points];
                if (count($miniTableData) === count($miniTableOrder)) {
                    $miniTableTeamOrder = array_column($miniTableOrder, 'team_id');
                    $tableData[$points] = array_replace(array_flip($miniTableTeamOrder), $miniTableData);
                } else {
                    $tableData[$points] = $miniTableData;
                }
            }

            return array_merge(...$tableData);
        }

        return null;
    }
}
