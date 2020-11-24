<?php

namespace App\Repositories;

use App\Match;
use Illuminate\Support\Carbon;

class Matches
{
    public function __construct()
    {
    }

    public function all()
    {
        return Match::all();
    }

    public function getMatches()
    {
        return Match::orderBy('id', 'desc')->get();
    }

    public function getMatchesBySeason($seasonId = null)
    {
        return Match::where('season_id', $seasonId)->orderBy('id', 'desc')->get();
    }

    public function getLastRecord()
    {
        $record = Match::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }
}
