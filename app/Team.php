<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Competition;
use App\Rule;

class Team extends Model
{
    protected $fillable = [
        'name', 'squad', 'primary_color_id', 'secondary_color_id', 'user_id', 'competition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(Match::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Match::class, 'away_team_id');
    }

    public function matches()
    {
        return $this->hasMany(Match::class, 'home_team_id')->orWhere('away_team_id', '=', $this->id);
    }

    public function getMatchesFormByCompetition(Competition $competition, $matchesFormCount = 5)
    {
        return $this->matches()->where(['competition_id' => $competition->id])->orderBy('id', 'desc')->take($matchesFormCount)->get();
    }

    public function getMatchesFormByCompetitionRule(Competition $competition, Rule $rule, $matchesFormCount = 5)
    {
        return $this->matches()->where(['competition_id' => $competition->id, 'rule_id' => $rule->id])->orderBy('id', 'desc')->take($matchesFormCount)->get();
    }
}
