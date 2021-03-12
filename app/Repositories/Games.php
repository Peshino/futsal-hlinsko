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

    public function getGamesFiltered(Competition $competition = null, Rule $rule = null, Team $team = null, $gamesStatus = 'all', $round = null, $order = 'desc')
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

        if ($team !== null) {
            $query = $query->where(function ($query) use ($team) {
                $query->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
            });
        }

        switch ($gamesStatus) {
            case 'results':
                $query = $query->where('start_datetime', '<=', Carbon::now());
                break;
            case 'schedule':
                $query = $query->where('start_datetime', '>', Carbon::now());
                break;
            case 'all':
                break;
            default:
        }

        return $query->orderBy('start_datetime', $order)->get();
    }

    public function getTeamGamesFormFiltered(Team $team, Competition $competition = null, Rule $rule = null, $toRound = null, $gamesFormCount = 5, $order = 'desc')
    {
        $query = Game::query();

        if ($team !== null) {
            $query = $query->where(function ($query) use ($team) {
                $query->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
            });
        }

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }

        if ($toRound !== null) {
            $query = $query->where('round', '<=', $toRound);
        }

        return $query->orderBy('start_datetime', $order)->take($gamesFormCount)->get();
    }

    public function getRoundsFiltered(Competition $competition = null, Rule $rule = null, $order = 'desc')
    {
        $rounds = [];
        $games = $this->getGamesFiltered($competition, $rule, null, 'all', null, $order);

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

    public function getTableData(Competition $competition, Rule $rule, $toRound = null)
    {
        $data = DB::select(
            'select 
            team_id, 
            teams.name team_name,
            count(*) games_count, 
            count(case when home_team_score > away_team_score then 1 end) wins, 
            count(case when home_team_score = away_team_score then 1 end) draws, 
            count(case when away_team_score > home_team_score then 1 end) losts, 
            sum(home_team_score) team_goals_scored, 
            sum(away_team_score) team_goals_received, 
            sum(home_team_score) - sum(away_team_score) team_goals_difference,
            sum(case when home_team_score > away_team_score then ? else 0 end + 
                case when home_team_score = away_team_score then 1 else 0 end) points
            from (
                select home_team_id team_id, home_team_score, away_team_score from games
                where competition_id = ? and rule_id = ? and round <= ?
            union all
                select away_team_id, away_team_score, home_team_score from games
                where competition_id = ? and rule_id = ? and round <= ?
            ) a
            INNER JOIN Teams ON teams.id = a.team_id
            group by team_id, team_name
            order by points desc, team_goals_difference desc;',
            array($rule->points_for_win, $competition->id, $rule->id, $toRound, $competition->id, $rule->id, $toRound)
        );

        return $data;
    }
}
