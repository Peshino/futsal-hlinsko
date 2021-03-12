<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = ['name', 'status', 'season_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function getLastRuleByPriority()
    {
        return $this->rules()->latest('priority')->first();
    }
}
