<?php

namespace App\Repositories;

use App\Competition;
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

    public function getLastRecord()
    {
        $record = Team::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getTeamsFiltered(Competition $competition = null, $order = 'asc', $limit = null)
    {
        $query = Team::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        return $query->orderBy('name', $order)->limit($limit)->get();
    }
}
