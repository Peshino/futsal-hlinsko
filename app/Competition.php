<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = ['name', 'season_id', 'competition_type_id', 'competition_style_id', 'user_id'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
