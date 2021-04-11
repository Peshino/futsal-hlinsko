<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function competitions()
    {
        return $this->hasMany(Competition::class)->orderBy('id');
    }
}
