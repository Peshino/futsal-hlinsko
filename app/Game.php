<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function goals()
    {
        return $this->hasMany(Goal::class)->orderBy('amount', 'desc');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    public function getResultByTeamId($teamId)
    {
        $teamId = (int) $teamId;

        if ($this->home_team_id === $teamId) {
            if ($this->home_team_score > $this->away_team_score) {
                return 'win';
            } elseif ($this->home_team_score < $this->away_team_score) {
                return 'loss';
            } else {
                return 'draw';
            }
        }

        if ($this->away_team_id === $teamId) {
            if ($this->home_team_score > $this->away_team_score) {
                return 'loss';
            } elseif ($this->home_team_score < $this->away_team_score) {
                return 'win';
            } else {
                return 'draw';
            }
        }

        return null;
    }

    public function getResult()
    {
        if ($this->home_team_score > $this->away_team_score) {
            return 'home';
        } elseif ($this->home_team_score < $this->away_team_score) {
            return 'away';
        } else {
            return 'draw';
        }

        return null;
    }

    public function hasScore()
    {
        if ($this->home_team_score !== null && $this->away_team_score !== null) {
            return true;
        }

        return false;
    }

    public function isCurrentlyBeingPlayed()
    {
        $startDateTime = Carbon::parse($this->start_datetime);
        $startDateTimeCarbon = Carbon::parse($this->start_datetime);
        $endDateTime = $startDateTimeCarbon->addMinutes($this->rule->game_duration);

        if ($startDateTime->lte(Carbon::now()) && $endDateTime->gte(Carbon::now()) && !$this->hasScore()) {
            return true;
        }

        return false;
    }
}
