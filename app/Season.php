<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['name', 'name_short', 'user_id'];

    public function competitions()
    {
        return $this->hasMany(Competition::class)->orderBy('id');
    }
}
