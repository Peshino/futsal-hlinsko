<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'round', 'start_date', 'start_time', 'home_team_id', 'away_team_id', 'home_team_score',
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
}
