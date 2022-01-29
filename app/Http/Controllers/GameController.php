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
use App\Repositories\Positions;
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
     * @param  string $section
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition, $section = 'results', Rule $rule = null)
    {
        if ($rule === null) {
            $rule = $competition->getRuleJustPlayedByPriority($section);
        }

        if ($rule !== null) {
            switch ($section) {
                case 'results':
                case 'table':
                case 'brackets':
                    $game = $rule->getLastResultByRound();
                    break;
                case 'schedule':
                    $game = $rule->getFirstSchedule();
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
            return redirect()->route('games.create', ['competition' => $competition->id]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  int $currentRound
     * @return \Illuminate\Http\Response
     */
    public function resultsParamsIndex(Competition $competition, Rule $rule, $currentRound = null)
    {
        $gamesRepository = new Games;
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results');

        if ($currentRound !== null) {
            $currentRound = (int) $currentRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'results', $currentRound);
        } else {
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'results');
        }

        return view('games.results-index', compact('competition', 'rule', 'currentRound', 'games', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  int $currentRound
     * @return \Illuminate\Http\Response
     */
    public function scheduleParamsIndex(Competition $competition, Rule $rule, $currentRound = null)
    {
        $gamesRepository = new Games;
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'schedule');

        if ($currentRound !== null) {
            $currentRound = (int) $currentRound;
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule', $currentRound);
        } else {
            $games = $gamesRepository->getGamesFiltered($competition, $rule, null, 'schedule');
        }

        return view('games.schedule-index', compact('competition', 'rule', 'currentRound', 'games', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  mixed $toRound
     * @return \Illuminate\Http\Response
     */
    public function tableParamsIndex(Competition $competition, Rule $rule, $toRound = null)
    {
        $gamesRepository = new Games;
        $positionsRepository = new Positions;

        $synchronizePositions = false;
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule, 'results');
        $currentRound = $toRound ?? null;
        $tableData = $gamesRepository->getTableData($competition, $rule, $toRound, true, true);
        $phases = $rule->phases;
        $phasesOrder = [
            'qualification' => [],
            'descent' => [],
        ];
        $fromToPhases = $phases->map->only(['from_position', 'to_position']);

        if (!empty($tableData)) {
            foreach ($tableData as $tablePosition => $tableItem) {
                $team = Team::find($tableItem->team_id);
                $teamForm = $gamesRepository->getTeamForm($competition, $team, $rule, $toRound);
                $teamFirstSchedule = $gamesRepository->getTeamFirstSchedule($competition, $team, $rule);

                $teamCurrentPosition = $positionsRepository->getTeamCurrentPosition($competition, $rule, $team, $currentRound);
                $teamPreviousPosition = $positionsRepository->getTeamPreviousPosition($competition, $rule, $team, $currentRound);

                if ($teamCurrentPosition === null || $teamPreviousPosition === null) {
                    $synchronizePositions = true;
                }

                $teamCurrentPosition = $teamCurrentPosition ?? ($tablePosition + 1);

                if (!empty($fromToPhases)) {
                    foreach ($fromToPhases as $key => $fromToPhase) {
                        $fromPosition = $fromToPhase['from_position'];
                        $toPosition = $fromToPhase['to_position'];

                        if ($teamCurrentPosition >= $fromPosition && $teamCurrentPosition <= $toPosition) {
                            $teamPhase = $phases[$key];

                            if (!in_array($teamPhase->id, $phasesOrder[$teamPhase->phase])) {
                                $phasesOrder[$teamPhase->phase][] = $teamPhase->id;
                            }

                            $teamPhase->order = array_search($teamPhase->id, $phasesOrder[$teamPhase->phase]);

                            $tableItem->team_phase = $teamPhase;
                            break;
                        }
                    }
                }

                $tableItem->team_form = $teamForm;
                $tableItem->team_first_schedule = $teamFirstSchedule;
                $tableItem->team_current_position = $teamCurrentPosition;
                $tableItem->team_previous_position = $teamPreviousPosition;
            }
        }

        if ($synchronizePositions) {
            $positionsRepository->synchronize($competition, $rule);
        }

        return view('games.table-index', compact('competition', 'rule', 'toRound', 'tableData', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  mixed $toRound
     * @return \Illuminate\Http\Response
     */
    public function bracketsParamsIndex(Competition $competition, Rule $rule, $toRound = null)
    {
        $brackets = [];
        $ruleNumberOfRounds = $rule->number_of_rounds;
        $teamsCount = count($rule->teams);
        $games = $rule->games;
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

        return view('games.brackets-index', compact('competition', 'rule', 'toRound', 'brackets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule|null  $rule
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition, Rule $rule = null)
    {
        if ($rule !== null) {
            $teams = $rule->teams;
        } else {
            $teams = $competition->teams;
        }

        return view('games.create', compact('competition', 'rule', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule|null  $rule
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Competition $competition, Rule $rule = null, Request $request)
    {
        $positionsRepository = new Positions;

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
            'competition_id' => 'required|numeric|min:1',
        ]);

        if ($rule !== null) {
            $attributes['rule_id'] = $rule->id;
        } else {
            $attributes += $request->validate(['rule_id' => 'required|numeric|min:1']);
            $rule = Rule::find($attributes['rule_id']);
        }

        $attributes['start_datetime'] = date('Y-m-d H:i:s', strtotime($attributes['start_date'] . ' ' . $attributes['start_time']));
        unset($attributes['start_date']);
        unset($attributes['start_time']);

        $gameCreated = auth()->user()->addGame($attributes);
        // Pozor! Při vytváření zápasu do playoff dojde k chybě, protože fce synchronize nemá data v $tableData
        $positionsSynchronized = $positionsRepository->synchronize($competition, $rule);

        if ($gameCreated !== null && $positionsSynchronized) {
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
        $goalsRepository = new Goals;
        $cardsRepository = new Cards;
        $positionsRepository = new Positions;
        $rule = Rule::find($game->rule_id);

        $attributes = $request->validate([
            'round' => 'required|numeric|min:1',
            'start_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
        ]);

        foreach ($teamTypes as $teamType) {
            $teamGoalsFiltered = $goalsRepository->getGoalsFiltered($competition, null, $game, $game->{$teamType . 'Team'});
            $teamCardsFiltered = $cardsRepository->getCardsFiltered($competition, null, $game, $game->{$teamType . 'Team'});

            if ($teamGoalsFiltered->isEmpty() && $teamCardsFiltered->isEmpty() && $game->{$teamType . '_team_id'} !== null) {
                $attributes += $request->validate([$teamType . '_team_id' => 'required|numeric|min:1']);
            } else {
                $attributes[$teamType . '_team_id'] = $game->{$teamType . '_team_id'};
            }
        }

        $attributes += $request->validate([
            'home_team_score' => 'nullable|numeric',
            'away_team_score' => 'nullable|numeric',
            'home_team_halftime_score' => 'nullable|numeric',
            'away_team_halftime_score' => 'nullable|numeric',
            'rule_id' => 'required|numeric|min:1',
            'competition_id' => 'required|numeric|min:1',
        ]);

        $ruleId = (int) $attributes['rule_id'];
        $competitionId = (int) $attributes['competition_id'];

        $attributes['start_datetime'] = date('Y-m-d H:i:s', strtotime($attributes['start_date'] . ' ' . $attributes['start_time']));
        unset($attributes['start_date']);
        unset($attributes['start_time']);

        if ($game->update($attributes)) {
            if ($rule->id === $ruleId) {
                if (!$positionsRepository->synchronize($competition, $rule)) {
                    $flashSuccess = false;
                }
            } else {
                $ruleUpdate = Rule::find($ruleId);

                // Pozor! Při úpravě zápasu z playoff na tabulku dojde k chybě, protože fce synchronize nemá data v $tableData
                if (!$positionsRepository->synchronize($competition, $rule) || !$positionsRepository->synchronize($competition, $ruleUpdate)) {
                    $flashSuccess = false;
                }
            }
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
     * @param  string $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, Game $game, $section = 'results')
    {
        $positionsRepository = new Positions;
        $rule = Rule::find($game->rule_id);
        $positionsSynchronized = $positionsRepository->synchronize($competition, $rule);

        if ($game->delete() && $positionsSynchronized) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('games.index', ['competition' => $competition->id, $section]);
    }
}
