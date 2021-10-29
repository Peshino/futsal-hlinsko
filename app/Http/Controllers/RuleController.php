<?php

namespace App\Http\Controllers;

use App\Rule;
use App\Competition;
use App\Phase;
use App\Repositories\Teams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition)
    {
        $teamsRepository = new Teams;
        $teams = $teamsRepository->getTeamsFiltered($competition);

        return view('rules.create', compact('competition', 'teams'));
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
            'name' => 'required|min:2|max:50',
            'type' => 'required|min:2|max:100',
            'system' => 'required|min:2|max:100',
            'apply_mutual_balance' => 'max:1',
            'priority' => 'required|numeric|min:1',
            'number_of_rounds' => 'nullable|numeric',
            'game_duration' => 'required|numeric|min:1',
            'points_for_win' => 'required|numeric|min:1',
            'games_day_min' => 'nullable|numeric',
            'games_day_max' => 'nullable|numeric',
            'team_games_day_round_min' => 'nullable|numeric',
            'team_games_day_round_max' => 'nullable|numeric',
            'game_days_times' => 'required|json|min:1|max:100',
            'case_of_draw' => 'required|min:2|max:100',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'break_start_date' => 'nullable|date_format:Y-m-d',
            'break_end_date' => 'nullable|date_format:Y-m-d',
            'competition_id' => 'required|numeric|min:1',
        ]);

        if ($request->type !== 'table') {
            $attributes['apply_mutual_balance'] = false;
        } else {
            $attributes['apply_mutual_balance'] = $request->has('apply_mutual_balance');
        }

        $ruleCreated = auth()->user()->addRule($attributes);

        if ($ruleCreated !== null) {
            $ruleCreated->teams()->sync($request->teams);
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
            return redirect()->route('rules.admin-show', ['competition' => $competition->id, 'rule' => $ruleCreated->id]);
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function show(Rule $rule)
    {
        return view('rules.show', compact('rule'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function adminShow(Competition $competition, Rule $rule)
    {
        $teams = $rule->teams;
        $phases = $rule->phases;

        return view('rules.admin-show', compact('competition', 'rule', 'teams', 'phases'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition, Rule $rule)
    {
        $teamsRepository = new Teams;

        $ruleTeams = $rule->teams;
        $teams = $teamsRepository->getTeamsFiltered($competition);
        $phases = $rule->phases;

        foreach ($teams as $team) {
            if ($ruleTeams->contains($team)) {
                $team->is_in_rule = true;
            } else {
                $team->is_in_rule = false;
            }
        }

        return view('rules.edit', compact('competition', 'rule', 'teams', 'phases'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition, Rule $rule)
    {
        $flashSuccess = true;
        $toDeletePhases = $rule->phases;

        $attributes = $request->validate([
            'name' => 'required|min:2|max:50',
            'type' => 'required|min:2|max:100',
            'system' => 'required|min:2|max:100',
            'apply_mutual_balance' => 'max:1',
            'priority' => 'required|numeric|min:1',
            'number_of_rounds' => 'nullable|numeric',
            'game_duration' => 'required|numeric|min:1',
            'points_for_win' => 'required|numeric|min:1',
            'games_day_min' => 'nullable|numeric',
            'games_day_max' => 'nullable|numeric',
            'team_games_day_round_min' => 'nullable|numeric',
            'team_games_day_round_max' => 'nullable|numeric',
            'game_days_times' => 'required|json|min:1|max:100',
            'case_of_draw' => 'required|min:2|max:100',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'break_start_date' => 'nullable|date_format:Y-m-d',
            'break_end_date' => 'nullable|date_format:Y-m-d',
            'competition_id' => 'required|numeric|min:1',
        ]);

        if ($request->has('phases')) {
            $phases = $request->input('phases');

            foreach ($phases as $key => $phase) {
                $validator = Validator::make($phase, [
                    'from_position' => 'required|numeric|min:1|max:999|lte:to_position',
                    'to_position' => 'required|numeric|min:1|max:999|gte:from_position',
                    'to_rule_id' => 'required|numeric|min:1',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $phaseAttributes = [
                    'from_position' => $phase['from_position'],
                    'to_position' => $phase['to_position'],
                    'phase' => $phase['phase'],
                    'to_rule_id' => $phase['to_rule_id'],
                    'rule_id' => $rule->id,
                    'competition_id' => $competition->id,
                ];

                if (isset($phase['id']) && !empty($phase['id'])) {
                    $id = (int) $phase['id'];
                    $toDeletePhase = Phase::find($id);
                    $toDeletePhases = $toDeletePhases->reject($toDeletePhase);

                    if ($toDeletePhase->update($phaseAttributes)) {
                    } else {
                        $flashSuccess = false;
                    }
                } else {
                    $phaseCreated = auth()->user()->addPhase($phaseAttributes);

                    if ($phaseCreated !== null) {
                    } else {
                        $flashSuccess = false;
                    }
                }
            }
        }

        if ($toDeletePhases->isNotEmpty()) {
            foreach ($toDeletePhases as $toDeletePhase) {
                if ($toDeletePhase->delete()) {
                } else {
                    $flashSuccess = false;
                }
            }
        }

        $rule->teams()->sync($request->teams);

        if ($request->type !== 'table') {
            $attributes['apply_mutual_balance'] = false;
        } else {
            $attributes['apply_mutual_balance'] = $request->has('apply_mutual_balance');
        }

        if ($rule->update($attributes)) {
        } else {
            $flashSuccess = false;
        }

        if ($flashSuccess) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('rules.admin-show', ['competition' => $competition->id, 'rule' => $rule->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, Rule $rule)
    {
        if ($rule->delete()) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('competitions.admin-show', ['competition' => $competition->id]);
    }
}
