<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'name', 'system', 'number_of_rounds', 'number_of_qualifiers', 'number_of_descending', 'priority',
        'match_duration', 'matches_day_min', 'matches_day_max', 'team_matches_day_round_min', 'team_matches_day_round_max',
        'match_days_times', 'case_of_draw', 'start_date', 'end_date', 'break_start_date', 'break_end_date', 'user_id', 'competition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }

    public function getLastMatchByRound()
    {
        return $this->matches()->latest('round')->first();
    }
}
