<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Game;
use App\Rule;
use App\Team;
use App\Goal;
use App\Repositories\Games;
use App\Repositories\Goals;
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
    public function index(Competition $competition, $section = 'results')
    {
        $lastRuleByPriority = $competition->getLastRuleByPriority();

        if ($lastRuleByPriority !== null) {
            $lastGameByRound = $lastRuleByPriority->getLastGameByRound();

            if ($lastGameByRound !== null) {
                return redirect()->route($section . '.params-index', ['competition' => $competition->id, 'rule' => $lastRuleByPriority->id, 'round' => $lastGameByRound->round]);
            } else {
                return redirect()->route('games.create', ['competition' => $competition->id]);
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
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule);

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
        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule);

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

        $rounds = $gamesRepository->getRoundsFiltered($competition, $rule);
        $tableData = $gamesRepository->getTableData($competition, $rule, $toRound);

        if (!empty($tableData)) {
            foreach ($tableData as $item) {
                $teamForm = $gamesRepository->getTeamGamesFormFiltered(Team::find($item->team_id), $competition, $rule, $toRound);

                if (count($teamForm) > 0) {
                    foreach ($teamForm as $game) {
                        $gameResult = $game->getResultByTeamId($item->team_id);
                        $game->result = $gameResult;
                    }
                }

                $item->team_form = $teamForm;
            }
        }

        return view('games.table-index', compact('competition', 'rule', 'toRound', 'tableData', 'rounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition)
    {
        return view('games.create', compact('competition'));
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
        $homeTeamGoals = $goalsRepository->getGoalsFiltered($competition, $game, $game->homeTeam);
        $awayTeamGoals = $goalsRepository->getGoalsFiltered($competition, $game, $game->awayTeam);

        return view('games.show', compact('competition', 'game', 'homeTeamGoals', 'awayTeamGoals'));
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
        $homeTeamGoals = $goalsRepository->getGoalsFiltered($competition, $game, $game->homeTeam);
        $awayTeamGoals = $goalsRepository->getGoalsFiltered($competition, $game, $game->awayTeam);

        return view('games.edit', compact('competition', 'game', 'homeTeamGoals', 'awayTeamGoals'));
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
        }

        if ($toDeleteGameGoals->isNotEmpty()) {
            foreach ($toDeleteGameGoals as $toDeleteGameGoal) {
                if ($toDeleteGameGoal->delete()) {
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
    public function destroy(Competition $competition, Game $game)
    {
        if ($game->delete()) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('games.index', ['competition' => $competition->id]);
    }
}
