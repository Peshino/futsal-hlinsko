<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $fillable = [
        'from_position', 'to_position', 'phase', 'to_rule_id', 'user_id', 'rule_id', 'competition_id'
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function toRule()
    {
        return $this->belongsTo(Rule::class, 'to_rule');
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
