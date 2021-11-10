<?php

namespace App\Repositories;

use App\Card;
use App\Player;
use App\Team;
use App\Game;
use App\Competition;
use App\Rule;

class Cards
{
    public function __construct()
    {
    }

    public function all()
    {
        return Card::all();
    }

    public function getLastRecord()
    {
        $record = Card::latest('created_at')->first();

        if ($record !== null) {
            return $record;
        }

        return null;
    }

    public function getCardsFiltered(Competition $competition = null, Rule $rule = null, Game $game = null, Team $team = null, Player $player = null, $order = 'desc', $limit = null)
    {
        $query = Card::query();

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

        return $query->limit($limit)->get();
    }

    public function getSummedCardsFiltered(Competition $competition = null, Rule $rule = null, Game $game = null, Team $team = null, Player $player = null, $order = 'desc', $cardType = null, $limit = null)
    {
        $query = Card::query();

        if ($cardType !== null) {
            $query->selectRaw('sum(' . $cardType . ') as ' . $cardType . ', player_id, team_id');
            $query = $query->where($cardType, '!=', 0);
        } else {
            $query->selectRaw('sum(yellow) as yellow, sum(red) as red, player_id, team_id');
        }

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

        if ($cardType !== null) {
            return $query->groupBy('player_id')->groupBy('team_id')->orderBy($cardType, $order)->limit($limit)->get();
        } else {
            return $query->groupBy('player_id')->groupBy('team_id')->limit($limit)->get();
        }
    }
}
