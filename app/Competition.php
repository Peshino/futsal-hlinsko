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
        return $this->hasMany(Rule::class)->orderBy('priority', 'desc');
    }

    public function teams()
    {
        return $this->hasMany(Team::class)->orderBy('name');
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

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function getLastRuleByPriority()
    {
        return $this->rules()->latest('priority')->first();
    }

    public function getRuleJustPlayedByPriority($section = null)
    {
        $rulesOrderedByPriority = $this->rules()->orderBy('priority', 'desc')->get();

        if ($rulesOrderedByPriority->isNotEmpty()) {
            foreach ($rulesOrderedByPriority as $rule) {
                if ($section !== null) {
                    if ($section === 'results') {
                        if ($rule->results()->exists()) {
                            return $rule;
                        }

                        continue;
                    }

                    if ($section === 'schedule') {
                        if ($rule->scheduleWithTeamsFilled()->exists()) {
                            return $rule;
                        }

                        continue;
                    }
                } else {
                    if ($rule->gamesWithTeamsFilled()->exists()) {
                        return $rule;
                    }
                }
            }
        }

        return null;
    }
}
