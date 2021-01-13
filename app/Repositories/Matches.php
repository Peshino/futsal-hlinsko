<?php

namespace App\Repositories;

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

    public function getMatches($order = 'desc')
    {
        return Match::orderBy('id', $order)->get();
    }

    public function getMatchesBySeason($seasonId, $order = 'desc')
    {
        return Match::where('season_id', $seasonId)->orderBy('id', $order)->get();
    }

    public function getMatchesByCompetitionRule($competitionId, $ruleId, $order = 'desc')
    {
        return Match::where(['competition_id' => $competitionId, 'rule_id' => $ruleId])->orderBy('start_date', $order)->orderBy('start_time', $order)->get();
    }

    public function getMatchesByCompetitionRuleRound($competitionId, $ruleId, $round, $order = 'desc')
    {
        return Match::where(['competition_id' => $competitionId, 'rule_id' => $ruleId, 'round' => $round])->orderBy('start_date', $order)->orderBy('start_time', $order)->get();
    }

    public function getTeamMatchesFormByCompetition(Team $team, Competition $competition, $matchesFormCount = 5)
    {
        return Match::where(function($query) use($team){
            $query->where('home_team_id', $team->id)
            ->orWhere('away_team_id', $team->id);
        })->where(['competition_id' => $competition->id])->orderBy('start_date', 'desc')->orderBy('start_time', 'desc')->take($matchesFormCount)->get();
    }

    public function getTeamMatchesFormByCompetitionRule(Team $team, Competition $competition, Rule $rule, $matchesFormCount = 5)
    {
        return Match::where(function($query) use($team){
            $query->where('home_team_id', $team->id)
            ->orWhere('away_team_id', $team->id);
        })->where(['competition_id' => $competition->id, 'rule_id' => $rule->id])->orderBy('start_date', 'desc')->orderBy('start_time', 'desc')->take($matchesFormCount)->get();
    }

    public function getTeamMatchesFormByCompetitionRuleToRound(Team $team, Competition $competition, Rule $rule, $toRound, $matchesFormCount = 5)
    {
        return Match::where(function($query) use($team){
            $query->where('home_team_id', $team->id)
            ->orWhere('away_team_id', $team->id);
        })->where(['competition_id' => $competition->id, 'rule_id' => $rule->id])->where('round', '<=', $toRound)->orderBy('start_date', 'desc')->orderBy('start_time', 'desc')->take($matchesFormCount)->get();
    }

    public function getLastRecord()
    {
        $record = Match::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    /**
     * Returns an array of rounds filtered by $competitionId, $ruleId.
     *
     * @param  int  $competitionId
     * @param  int  $ruleId
     * @return array $rounds
     */
    public function getRoundsByCompetitionRule($competitionId, $ruleId, $order = 'desc')
    {
        $rounds = [];
        $matches = $this->getMatchesByCompetitionRule($competitionId, $ruleId, $order);

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
