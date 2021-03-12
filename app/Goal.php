<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'amount', 'player_id', 'team_id', 'game_id', 'user_id', 'competition_id'
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

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
