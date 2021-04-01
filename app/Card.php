<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'yellow', 'red', 'player_id', 'team_id', 'game_id', 'user_id', 'rule_id', 'competition_id'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

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
}
