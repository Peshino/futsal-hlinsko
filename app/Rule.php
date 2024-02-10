<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'name', 'type', 'system', 'apply_mutual_balance', 'number_of_rounds', 'priority', 'game_duration', 'points_for_win', 'games_day_min', 'games_day_max', 'team_games_day_round_min', 'team_games_day_round_max', 'game_days_times', 'case_of_draw', 'start_date', 'end_date', 'break_start_date', 'break_end_date', 'user_id', 'competition_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class)->orderBy('name')->withTimestamps();
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function getLastGameByRound()
    {
        return $this->games()->latest('round')->first();
    }

    public function results()
    {
        if (auth()->user() !== null && auth()->user()->can('crud_games')) {
            return $this->hasMany(Game::class)->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $this->game_duration . ' MINUTE) <= NOW()');
        } else {
            return $this->hasMany(Game::class)->whereNotNull('home_team_score')->whereNotNull('away_team_score')->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $this->game_duration . ' MINUTE) <= NOW()');
        }
    }

    public function getLastResultByRound()
    {
        return $this->results()->latest('round')->first();
    }

    public function schedule()
    {
        return $this->hasMany(Game::class)->whereRaw('DATE_ADD(`start_datetime`, INTERVAL ' . $this->game_duration . ' MINUTE) > NOW()');
    }

    public function phases()
    {
        return $this->hasMany(Phase::class);
    }

    public function getFirstSchedule()
    {
        return $this->schedule()->first();
    }

    public function gamesToBePlayed()
    {
        $gamesToBePlayed = 0;
        $teamsCount = count($this->competition->teams);
        $system = $this->system === 'one_rounded' ? 1 : 2;

        if ($this->type === 'table') {
            $gamesToBePlayed = ($system * ($teamsCount * ($teamsCount - 1))) / 2;
        }

        if ($this->type === 'brackets') {
            $gamesToBePlayed = null; // TODO
        }

        return $gamesToBePlayed;
    }

    public function isFinished()
    {
        $gamesPlayed = count($this->games);
        $gamesToBePlayed = $this->gamesToBePlayed();

        return $gamesPlayed === $gamesToBePlayed;
    }

    public function isAppliedMutualBalance()
    {
        return $this->apply_mutual_balance === 1 ? true : false;
    }

    public function getBrackets(): array
    {
        $brackets = [];

        if ($this->type === 'brackets') {
            $ruleNumberOfRounds = $this->number_of_rounds;
            $teamsCount = count($this->teams);
            $games = $this->games;
            $isThirdPlaceGame = $teamsCount !== (int) (2 ** $ruleNumberOfRounds);

            for ($i = 0; $i < $ruleNumberOfRounds; $i++) {
                $round = $ruleNumberOfRounds - $i;
                $gamesOfRound = $games->where('round', $round);
                $gamesOfRoundCount = count($gamesOfRound);

                if ($i === 0) {
                    if ($gamesOfRound->isEmpty()) {
                        $gamesOfRound->push(null);
                    }

                    $brackets['final'] = $gamesOfRound;
                } elseif ($i === 1 && $isThirdPlaceGame) {
                    if ($gamesOfRound->isEmpty()) {
                        $gamesOfRound->push(null);
                    }

                    $brackets['third_place_game'] = $gamesOfRound;
                } else {
                    $subtractor = $isThirdPlaceGame ? 1 : 0;
                    $numberOfNullGamesToPush = (int) (2 ** ($i - $subtractor) - $gamesOfRoundCount);

                    for ($x = 0; $x < $numberOfNullGamesToPush; $x++) {
                        $gamesOfRound->push(null);
                    }

                    $brackets['stage_' . ($i - $subtractor)] = $gamesOfRound;
                }
            }

            $brackets = array_reverse($brackets);
        }

        return $brackets;
    }
}
