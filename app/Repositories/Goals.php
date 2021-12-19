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

    public function getGoalsFiltered(Competition $competition = null, Rule $rule = null, Game $game = null, Team $team = null, Player $player = null, $order = 'desc', $limit = null)
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

        return $query->orderBy('amount', $order)->limit($limit)->get();
    }

    public function getSummedGoalsFiltered(Competition $competition = null, Rule $rule = null, Game $game = null, Team $team = null, Player $player = null, $order = 'desc', $limit = null)
    {
        $query = Goal::query();
        $query->selectRaw('sum(amount) as amount, goals.player_id AS player_id, goals.team_id AS team_id, players.lastname AS lastname, players.firstname AS firstname');

        if ($competition !== null) {
            $query = $query->where('goals.competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('goals.rule_id', $rule->id);
        }

        if ($game !== null) {
            $query = $query->where('goals.game_id', $game->id);
        }

        if ($team !== null) {
            $query = $query->where('goals.team_id', $team->id);
        }

        if ($player !== null) {
            $query = $query->where('goals.player_id', $player->id);
        }

        $query->join('players', 'players.id', '=', 'goals.player_id');

        return $query->groupBy('player_id')->groupBy('team_id')->orderBy('amount', $order)->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->limit($limit)->get();
    }
}
