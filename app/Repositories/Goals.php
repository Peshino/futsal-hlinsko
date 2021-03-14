<?php

namespace App\Repositories;

use App\Goal;
use App\Player;
use App\Team;
use App\Game;
use App\Competition;
use App\Rule;

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

    public function getGoalsFiltered(Competition $competition = null, Rule $rule = null, Game $game = null, Team $team = null, Player $player = null, $order = 'desc')
    {
        $query = Goal::query();

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }

        if ($game !== null) {
            $query = $query->where('game_id', $game->id);
        }

        if ($team !== null) {
            $query = $query->where('team_id', $team->id);
        }

        if ($player !== null) {
            $query = $query->where('player_id', $player->id);
        }

        return $query->orderBy('amount', $order)->get();
    }

    public function getSummedGoalsFiltered(Competition $competition = null, Rule $rule = null, Game $game = null, Team $team = null, Player $player = null, $order = 'desc')
    {
        $query = Goal::query();
        $query->selectRaw('sum(amount) as amount, player_id, team_id');

        if ($competition !== null) {
            $query = $query->where('competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('rule_id', $rule->id);
        }

        if ($game !== null) {
            $query = $query->where('game_id', $game->id);
        }

        if ($team !== null) {
            $query = $query->where('team_id', $team->id);
        }

        if ($player !== null) {
            $query = $query->where('player_id', $player->id);
        }

        return $query->groupBy('player_id')->groupBy('team_id')->orderBy('amount', $order)->get();
    }
}
