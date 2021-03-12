<?php

namespace App\Repositories;

use App\Goal;
use App\Player;
use App\Team;
use App\Match;
use App\Competition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Goals
{
    public function __construct()
    {
    }

    public function all()
    {
        return Goal::all();
    }

    public function getLastRecord()
    {
        $record = Goal::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getGoalsFiltered(Competition $competition = null, Match $match = null, Team $team = null, Player $player = null, $order = 'desc')
    {
        $query = Goal::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($match !== null) {
            $query = $query->where('match_id', $match->id);
        }

        if ($team !== null) {
            $query = $query->where('team_id', $team->id);
        }

        if ($player !== null) {
            $query = $query->where('player_id', $player->id);
        }

        return $query->orderBy('amount', $order)->get();
    }
}
