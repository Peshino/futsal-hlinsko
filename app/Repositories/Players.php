<?php

namespace App\Repositories;

use App\Competition;
use App\Team;
use App\Player;

class Players
{
    public function __construct()
    {
    }

    public function all()
    {
        return Player::all();
    }

    public function getLastRecord()
    {
        $record = Player::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getPlayersFiltered(Competition $competition = null, Team $team = null, $order = 'desc')
    {
        $query = Player::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($team !== null) {
            $query = $query->where('team_id', $team->id);
        }

        return $query->orderBy('lastname', $order)->orderBy('firstname', $order)->get();
    }
}
