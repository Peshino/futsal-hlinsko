<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'name', 'system', 'number_of_rounds', 'number_of_qualifiers', 'number_of_descending', 'priority',
        'game_duration', 'points_for_win', 'games_day_min', 'games_day_max', 'team_games_day_round_min', 'team_games_day_round_max', 'game_days_times', 'case_of_draw', 'start_date', 'end_date', 'break_start_date', 'break_end_date', 'user_id', 'competition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function getLastGameByRound()
    {
        return $this->games()->latest('round')->first();
    }

    public function results()
    {
        return $this->hasMany(Game::class)->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $this->game_duration . ' MINUTE) <= NOW()');
    }

    public function getLastResultByRound()
    {
        return $this->results()->latest('round')->first();
    }

    public function schedule()
    {
        return $this->hasMany(Game::class)->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $this->game_duration . ' MINUTE) > NOW()');
    }

    public function getFirstScheduleByRound()
    {
        return $this->schedule()->first();
    }
}
