<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'round', 'start_datetime', 'home_team_id', 'away_team_id', 'home_team_score',
        'away_team_score', 'home_team_halftime_score', 'away_team_halftime_score', 'user_id', 'rule_id', 'competition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class);
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class);
    }

    public function getResultByTeamId($teamId)
    {
        $teamId = (int) $teamId;

        if ($this->home_team_id === $teamId) {
            if ($this->home_team_score > $this->away_team_score) {
                return 'win';
            } elseif ($this->home_team_score < $this->away_team_score) {
                return 'lost';
            } else {
                return 'draw';
            }
        }

        if ($this->away_team_id === $teamId) {
            if ($this->home_team_score > $this->away_team_score) {
                return 'lost';
            } elseif ($this->home_team_score < $this->away_team_score) {
                return 'win';
            } else {
                return 'draw';
            }
        }

        return null;
    }

    public function goals()
    {
        return $this->hasMany(Goal::class)->orderBy('amount', 'desc');
    }
}
