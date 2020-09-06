<?php

namespace App\Repositories;

use App\Season;
use Illuminate\Support\Carbon;

class Seasons
{
    public function __construct()
    {
    }

    public function all()
    {
        return Season::all();
    }

    public function getSeasons()
    {
        return Season::orderBy('id', 'desc')->get();
    }

    public function getLastRecord()
    {
        $record = Season::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }
}
