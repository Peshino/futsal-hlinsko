<?php

namespace App\Repositories;

use App\Team;

class Teams
{
    public function __construct()
    {
    }

    public function all()
    {
        return Team::all();
    }

    public function getTeams()
    {
        return Team::orderBy('name', 'desc')->get();
    }
}
