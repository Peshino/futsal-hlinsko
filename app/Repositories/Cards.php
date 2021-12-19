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
            $query->selectRaw('sum(' . $cardType . ') as ' . $cardType . ', cards.player_id AS player_id, cards.team_id AS team_id, players.lastname AS lastname, players.firstname AS firstname');
            $query = $query->where($cardType, '!=', 0);
        } else {
            $query->selectRaw('sum(yellow) as yellow, sum(red) as red, cards.player_id AS player_id, cards.team_id AS team_id, players.lastname AS lastname, players.firstname AS firstname');
        }

        if ($competition !== null) {
            $query = $query->where('cards.competition_id', $competition->id);
        }

        if ($rule !== null) {
            $query = $query->where('cards.rule_id', $rule->id);
        }

        if ($game !== null) {
            $query = $query->where('cards.game_id', $game->id);
        }

        if ($team !== null) {
            $query = $query->where('cards.team_id', $team->id);
        }

        if ($player !== null) {
            $query = $query->where('cards.player_id', $player->id);
        }

        $query->join('players', 'players.id', '=', 'cards.player_id');

        if ($cardType !== null) {
            return $query->groupBy('player_id')->groupBy('team_id')->orderBy($cardType, $order)->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->limit($limit)->get();
        } else {
            return $query->groupBy('player_id')->groupBy('team_id')->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->limit($limit)->get();
        }
    }
}
