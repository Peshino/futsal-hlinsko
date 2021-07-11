<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position', 'team_id', 'game_id', 'round', 'rule_id', 'competition_id'
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
