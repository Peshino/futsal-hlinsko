<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Color;
use App\Competition;
use App\Rule;

class Team extends Model
{
    protected $fillable = [
        'name', 'name_short', 'history_code', 'logo', 'web_presentation', 'primary_color_id', 'secondary_color_id', 'superior_team_id', 'inferior_team_id', 'user_id', 'competition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class)->orderBy('lastname', 'asc')->orderBy('firstname', 'asc');
    }

    public function rules()
    {
        return $this->belongsToMany(Rule::class)->withTimestamps();
    }

    public function homeGames()
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames()
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    public function primaryColor()
    {
        return $this->belongsTo(Color::class);
    }

    public function secondaryColor()
    {
        return $this->belongsTo(Color::class);
    }

    public function superiorTeam()
    {
        return $this->belongsTo($this);
    }

    public function inferiorTeam()
    {
        return $this->belongsTo($this);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class)->orderBy('amount', 'desc');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function getLastPlayedRule()
    {
        return $this->rules()->latest('priority')->first();
    }

    public function getLastPosition()
    {
        return $this->positions()->latest('round')->first();
    }
}
