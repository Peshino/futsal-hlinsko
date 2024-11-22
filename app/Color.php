<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function teams()
    {
        return $this->hasMany(Team::class)->orderBy('name');
    }
}
