<?php

namespace App\Repositories;

use App\Competition;
use Illuminate\Support\Carbon;

class Competitions
{
    public function __construct()
    {
    }

    public function all()
    {
        return Competition::all();
    }

    public function getCompetitions()
    {
        return Competition::orderBy('id', 'desc')->get();
    }

    public function getCompetitionsBySeason($seasonId = null)
    {
        return Competition::where('season_id', $seasonId)->orderBy('id', 'desc')->get();
    }

    public function getLastRecord()
    {
        $record = Competition::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }
}
