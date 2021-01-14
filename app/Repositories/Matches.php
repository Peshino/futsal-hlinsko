<?php

namespace App\Repositories;

use App\Season;
use App\Match;
use App\Competition;
use App\Rule;
use App\Team;
use Illuminate\Support\Facades\DB;

class Matches
{
    public function __construct()
    {
    }

    public function all()
    {
        return Match::all();
    }

    public function getLastRecord()
    {
        $record = Match::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getMatchesFiltered(Competition $competition = null, Rule $rule = null, $round = null, $order = 'desc')
    {
        $query = Match::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }
        
        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }
        
        if ($round !== null) {
            $query = $query->where('round', $round);
        }
        
        return $query->orderBy('start_date', $order)->orderBy('start_time', $order)->get();
    }

    public function getTeamMatchesFormFiltered(Team $team, Competition $competition = null, Rule $rule = null, $toRound = null, $matchesFormCount = 5, $order = 'desc')
    {
        $query = Match::query();
        $query = $query->where(function($query) use($team){
            $query->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id);
        });

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }
        
        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }
        
        if ($toRound !== null) {
            $query = $query->where('round', '<=', $toRound);
        }
        
        return $query->orderBy('start_date', $order)->orderBy('start_time', $order)->take($matchesFormCount)->get();
    }

    public function getRoundsFiltered(Competition $competition = null, Rule $rule = null, $order = 'desc')
    {
        $rounds = [];
        $matches = $this->getMatchesFiltered($competition, $rule, null, $order);

        if ($matches !== null) {
            $matchesRounds = collect($matches)->unique('round')->values();

            if ($matchesRounds !== null) {
                foreach ($matchesRounds as $matchesRound) {
                    $rounds[] = $matchesRound->round;
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
            count(*) matches_count, 
            count(case when home_team_score > away_team_score then 1 end) wins, 
            count(case when home_team_score = away_team_score then 1 end) draws, 
            count(case when away_team_score > home_team_score then 1 end) losts, 
            sum(home_team_score) team_goals_scored, 
            sum(away_team_score) team_goals_received, 
            sum(home_team_score) - sum(away_team_score) team_goals_difference,
            sum(case when home_team_score > away_team_score then ? else 0 end + 
                case when home_team_score = away_team_score then 1 else 0 end) points
            from (
                select home_team_id team_id, home_team_score, away_team_score from matches
                where competition_id = ? and rule_id = ? and round <= ?
            union all
                select away_team_id, away_team_score, home_team_score from matches
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
