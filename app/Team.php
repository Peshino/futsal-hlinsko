<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Competition;
use App\Rule;

class Team extends Model
{
    protected $fillable = [
        'name', 'name_short', 'unique_code', 'logo', 'web_presentation', 'primary_color_id', 'secondary_color_id', 'superior_team_id', 'inferior_team_id', 'user_id', 'competition_id'
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

    public function superiorTeam()
    {
        return $this->belongsTo($this);
    }

    public function inferiorTeam()
    {
        return $this->belongsTo($this);
    }
}
