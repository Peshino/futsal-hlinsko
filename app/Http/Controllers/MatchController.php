<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Match;
use App\Rule;
use App\Team;
use App\Goal;
use App\Repositories\Matches;
use App\Repositories\Goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud_matches')->only(['create', 'store', 'edit', 'update', 'destroy']);
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
            $lastMatchByRound = $lastRuleByPriority->getLastMatchByRound();

            if ($lastMatchByRound !== null) {
                return redirect()->route($section . '.params-index', ['competition' => $competition->id, 'rule' => $lastRuleByPriority->id, 'round' => $lastMatchByRound->round]);
            } else {
                return redirect()->route('matches.create', ['competition' => $competition->id]);
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
        $matchesRepository = new Matches;
        $rounds = $matchesRepository->getRoundsFiltered($competition, $rule);

        if ($actualRound !== null) {
            $actualRound = (int) $actualRound;
            $matches = $matchesRepository->getMatchesFiltered($competition, $rule, null, 'results', $actualRound);
        } else {
            $matches = $matchesRepository->getMatchesFiltered($competition, $rule, null, 'results');
        }

        return view('matches.results-index', compact('competition', 'rule', 'actualRound', 'matches', 'rounds'));
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
        $matchesRepository = new Matches;
        $rounds = $matchesRepository->getRoundsFiltered($competition, $rule);

        if ($actualRound !== null) {
            $actualRound = (int) $actualRound;
            $matches = $matchesRepository->getMatchesFiltered($competition, $rule, null, 'schedule', $actualRound);
        } else {
            $matches = $matchesRepository->getMatchesFiltered($competition, $rule, null, 'schedule');
        }

        return view('matches.schedule-index', compact('competition', 'rule', 'actualRound', 'matches', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function tableParamsIndex(Competition $competition, Rule $rule, $toRound = null)
    {
        $matchesRepository = new Matches;

        $rounds = $matchesRepository->getRoundsFiltered($competition, $rule);
        $tableData = $matchesRepository->getTableData($competition, $rule, $toRound);

        if (!empty($tableData)) {
            foreach ($tableData as $item) {
                $teamForm = $matchesRepository->getTeamMatchesFormFiltered(Team::find($item->team_id), $competition, $rule, $toRound);

                if (count($teamForm) > 0) {
                    foreach ($teamForm as $match) {
                        $matchResult = $match->getResultByTeamId($item->team_id);
                        $match->result = $matchResult;
                    }
                }

                $item->team_form = $teamForm;
            }
        }

        return view('matches.table-index', compact('competition', 'rule', 'toRound', 'tableData', 'rounds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition)
    {
        return view('matches.create', compact('competition'));
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

        $matchCreated = auth()->user()->addMatch($attributes);

        if ($matchCreated !== null) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
            return redirect()->route('matches.show', ['competition' => $competition->id, 'match' => $matchCreated->id]);
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition, Match $match)
    {
        $goalsRepository = new Goals;
        $homeTeamGoals = $goalsRepository->getGoalsFiltered($competition, $match, $match->homeTeam);
        $awayTeamGoals = $goalsRepository->getGoalsFiltered($competition, $match, $match->awayTeam);

        return view('matches.show', compact('competition', 'match', 'homeTeamGoals', 'awayTeamGoals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition, Match $match)
    {
        $goalsRepository = new Goals;
        $homeTeamGoals = $goalsRepository->getGoalsFiltered($competition, $match, $match->homeTeam);
        $awayTeamGoals = $goalsRepository->getGoalsFiltered($competition, $match, $match->awayTeam);

        return view('matches.edit', compact('competition', 'match', 'homeTeamGoals', 'awayTeamGoals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition, Match $match)
    {
        $flashSuccess = true;
        $teamTypes = ['home', 'away'];
        $toDeleteMatchGoals = $match->goals;

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

        if ($match->update($attributes)) {
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
                        'match_id' => $match->id,
                        'competition_id' => $competitionId,
                    ];

                    if (isset($teamGoal['id']) && !empty($teamGoal['id'])) {
                        $id = (int) $teamGoal['id'];
                        $goal = Goal::find($id);
                        $toDeleteMatchGoals = $toDeleteMatchGoals->reject($goal);

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

        if ($toDeleteMatchGoals->isNotEmpty()) {
            foreach ($toDeleteMatchGoals as $toDeleteMatchGoal) {
                if ($toDeleteMatchGoal->delete()) {
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

        return redirect()->route('matches.show', ['competition' => $competition->id, 'match' => $match->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, Match $match)
    {
        if ($match->delete()) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('matches.index', ['competition' => $competition->id]);
    }
}
