<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Game;
use App\Rule;
use App\Team;
use App\Goal;
use App\Card;
use App\Repositories\Games;
use App\Repositories\Goals;
use App\Repositories\Cards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud_games')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition, $section = 'results', Rule $rule = null)
    {
        if ($rule === null) {
            $rule = $competition->getRuleJustPlayed();
        }

        if ($rule !== null) {
            switch ($section) {
                case 'results':
                case 'table':
                case 'brackets':
                    $game = $rule->getLastResultByRound();
                    break;
                case 'schedule':
                    $game = $rule->getFirstScheduleByRound();
                    break;
                default:
                    $game = $rule->getLastGameByRound();
            }

            if ($game !== null) {
                return redirect()->route($section . '.params-index', ['competition' => $competition->id, 'rule' => $rule->id, 'round' => $game->round]);
            } else {
                return redirect()->route($section . '.params-index', ['competition' => $competition->id, 'rule' => $rule->id]);
                // return redirect()->route('games.create', ['competition' => $competition->id]);
            }
        } else {
            return redirect()->route('rules.create', ['competition' => $competition->id]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  int $actualRound
     * @return \Illuminate\Http\Response
     */
    public function resultsParamsIndex(Competition $competition, Rule $rule, $actualRound = null)
    {
        $gamesRepository = new Games;
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results');

        if ($actualRound !== null) {
            $actualRound = (int) $actualRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'results', $actualRound);
        } else {
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'results');
        }

        return view('games.results-index', compact('competition', 'rule', 'actualRound', 'games', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  int $actualRound
     * @return \Illuminate\Http\Response
     */
    public function scheduleParamsIndex(Competition $competition, Rule $rule, $actualRound = null)
    {
        $gamesRepository = new Games;
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'schedule');

        if ($actualRound !== null) {
            $actualRound = (int) $actualRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule', $actualRound);
        } else {
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule');
        }

        return view('games.schedule-index', compact('competition', 'rule', 'actualRound', 'games', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function tableParamsIndex(Competition $competition, Rule $rule, $toRound = null)
    {
        $gamesRepository = new Games;

        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results');
        $tableData = $gamesRepository->getTableData($competition, $rule, $toRound);
        $miniTablesFromTableData = $gamesRepository->getMiniTablesFromTableData($tableData);
        $orderedMiniTables = $gamesRepository->orderMiniTables($miniTablesFromTableData, $competition, $rule, $toRound, true, true);
        $tableFinal = array_merge(...$orderedMiniTables);

        if (!empty($tableFinal)) {
            foreach ($tableFinal as $item) {
                $teamForm = $gamesRepository->getGamesFiltered($competition, $rule, Team::find($item->team_id), 'results', null, $toRound, 5);

                if (count($teamForm) > 0) {
                    foreach ($teamForm as $game) {
                        $gameResult = $game->getResultByTeamId($item->team_id);
                        $game->result = $gameResult;
                    }
                }

                $item->team_form = $teamForm;
            }
        }

        return view('games.table-index', compact('competition', 'rule', 'toRound', 'tableFinal', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function bracketsParamsIndex(Competition $competition, Rule $rule, $toRound = null)
    {
        $gamesRepository = new Games;

        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results');

        return view('games.brackets-index', compact('competition', 'rule', 'toRound', 'rounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition, Rule $rule = null)
    {
        return view('games.create', compact('competition', 'rule'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Competition  $competition
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Competition $competition, Request $request)
    {
        $attributes = $request->validate([
            'round' => 'required|numeric|min:1',
            'start_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'home_team_id' => 'required|numeric|min:1',
            'away_team_id' => 'required|numeric|min:1',
            'home_team_score' => 'nullable|numeric',
            'away_team_score' => 'nullable|numeric',
            'home_team_halftime_score' => 'nullable|numeric',
            'away_team_halftime_score' => 'nullable|numeric',
            'rule_id' => 'required|numeric|min:1',
            'competition_id' => 'required|numeric|min:1',
        ]);

        $attributes['start_datetime'] = date('Y-m-d H:i:s', strtotime($attributes['start_date'] . ' ' . $attributes['start_time']));
        unset($attributes['start_date']);
        unset($attributes['start_time']);

        $gameCreated = auth()->user()->addGame($attributes);

        if ($gameCreated !== null) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
            return redirect()->route('games.show', ['competition' => $competition->id, 'game' => $gameCreated->id]);
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition, Game $game)
    {
        $goalsRepository = new Goals;
        $homeTeamGoals = $goalsRepository->getGoalsFiltered($competition, null, $game, $game->homeTeam);
        $awayTeamGoals = $goalsRepository->getGoalsFiltered($competition, null, $game, $game->awayTeam);

        $cardsRepository = new Cards;
        $homeTeamCards = $cardsRepository->getCardsFiltered($competition, null, $game, $game->homeTeam);
        $awayTeamCards = $cardsRepository->getCardsFiltered($competition, null, $game, $game->awayTeam);

        return view('games.show', compact('competition', 'game', 'homeTeamGoals', 'awayTeamGoals', 'homeTeamCards', 'awayTeamCards'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition, Game $game)
    {
        $goalsRepository = new Goals;
        $homeTeamGoals = $goalsRepository->getGoalsFiltered($competition, null, $game, $game->homeTeam);
        $awayTeamGoals = $goalsRepository->getGoalsFiltered($competition, null, $game, $game->awayTeam);

        $cardsRepository = new Cards;
        $homeTeamCards = $cardsRepository->getCardsFiltered($competition, null, $game, $game->homeTeam);
        $awayTeamCards = $cardsRepository->getCardsFiltered($competition, null, $game, $game->awayTeam);

        return view('games.edit', compact('competition', 'game', 'homeTeamGoals', 'awayTeamGoals', 'homeTeamCards', 'awayTeamCards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition, Game $game)
    {
        $flashSuccess = true;
        $teamTypes = ['home', 'away'];
        $toDeleteGameGoals = $game->goals;
        $toDeleteGameCards = $game->cards;

        $attributes = $request->validate([
            'round' => 'required|numeric|min:1',
            'start_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'home_team_id' => 'required|numeric|min:1',
            'away_team_id' => 'required|numeric|min:1',
            'home_team_score' => 'nullable|numeric',
            'away_team_score' => 'nullable|numeric',
            'home_team_halftime_score' => 'nullable|numeric',
            'away_team_halftime_score' => 'nullable|numeric',
            'rule_id' => 'required|numeric|min:1',
            'competition_id' => 'required|numeric|min:1',
        ]);

        $ruleId = $attributes['rule_id'];
        $competitionId = $attributes['competition_id'];

        $attributes['start_datetime'] = date('Y-m-d H:i:s', strtotime($attributes['start_date'] . ' ' . $attributes['start_time']));
        unset($attributes['start_date']);
        unset($attributes['start_time']);

        if ($game->update($attributes)) {
        } else {
            $flashSuccess = false;
        }

        foreach ($teamTypes as $teamType) {
            if ($request->has($teamType . '_team_goals')) {
                $teamGoals = $request->input($teamType . '_team_goals');

                foreach ($teamGoals as $key => $teamGoal) {
                    $validator = Validator::make($teamGoal, [
                        'player' => 'required|numeric|min:1',
                        'amount' => 'required|numeric|min:1',
                        'team' => 'required|numeric|min:1',
                    ]);

                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }

                    $attributes = [
                        'amount' => $teamGoal['amount'],
                        'player_id' => $teamGoal['player'],
                        'team_id' => $teamGoal['team'],
                        'game_id' => $game->id,
                        'rule_id' => $ruleId,
                        'competition_id' => $competitionId,
                    ];

                    if (isset($teamGoal['id']) && !empty($teamGoal['id'])) {
                        $id = (int) $teamGoal['id'];
                        $goal = Goal::find($id);
                        $toDeleteGameGoals = $toDeleteGameGoals->reject($goal);

                        if ($goal->update($attributes)) {
                        } else {
                            $flashSuccess = false;
                        }
                    } else {
                        $goalCreated = auth()->user()->addGoal($attributes);

                        if ($goalCreated !== null) {
                        } else {
                            $flashSuccess = false;
                        }
                    }
                }
            }

            if ($request->has($teamType . '_team_cards')) {
                $teamCards = $request->input($teamType . '_team_cards');

                foreach ($teamCards as $key => $teamCard) {
                    $validator = Validator::make($teamCard, [
                        'player' => 'required|numeric|min:1',
                        'yellow' => 'min:0|max:1',
                        'red' => 'min:0|max:1',
                        'team' => 'required|numeric|min:1',
                    ]);

                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }

                    $attributes = [
                        'yellow' => $teamCard['yellow'] ?? 0,
                        'red' => $teamCard['red'] ?? 0,
                        'player_id' => $teamCard['player'],
                        'team_id' => $teamCard['team'],
                        'game_id' => $game->id,
                        'rule_id' => $ruleId,
                        'competition_id' => $competitionId,
                    ];

                    if (isset($teamCard['id']) && !empty($teamCard['id'])) {
                        $id = (int) $teamCard['id'];
                        $card = Card::find($id);
                        $toDeleteGameCards = $toDeleteGameCards->reject($card);

                        if ($card->update($attributes)) {
                        } else {
                            $flashSuccess = false;
                        }
                    } else {
                        $cardCreated = auth()->user()->addCard($attributes);

                        if ($cardCreated !== null) {
                        } else {
                            $flashSuccess = false;
                        }
                    }
                }
            }
        }

        if ($toDeleteGameGoals->isNotEmpty()) {
            foreach ($toDeleteGameGoals as $toDeleteGameGoal) {
                if ($toDeleteGameGoal->delete()) {
                } else {
                    $flashSuccess = false;
                }
            }
        }

        if ($toDeleteGameCards->isNotEmpty()) {
            foreach ($toDeleteGameCards as $toDeleteGameCard) {
                if ($toDeleteGameCard->delete()) {
                } else {
                    $flashSuccess = false;
                }
            }
        }

        if ($flashSuccess) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('games.show', ['competition' => $competition->id, 'game' => $game->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, Game $game, $section = 'results')
    {
        if ($game->delete()) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('games.index', ['competition' => $competition->id, $section]);
    }
}
