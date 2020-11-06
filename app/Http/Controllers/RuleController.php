<?php

namespace App\Http\Controllers;

use App\Rule;
use App\Competition;
use Illuminate\Http\Request;

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
        return view('rules.create', compact('competition'));
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
            'name' => 'required|min:2|max:100',
            'system' => 'required|min:2|max:100',
            'priority' => 'required|numeric|min:1',
            'number_of_rounds' => 'nullable|numeric',
            'number_of_qualifiers' => 'nullable|numeric',
            'number_of_descending' => 'nullable|numeric',
            'match_duration' => 'nullable|numeric',
            'matches_day_min' => 'nullable|numeric',
            'matches_day_max' => 'nullable|numeric',
            'team_matches_day_round_min' => 'nullable|numeric',
            'team_matches_day_round_max' => 'nullable|numeric',
            'match_days_times' => 'required|json|min:1|max:100',
            'case_of_draw' => 'required|min:2|max:100',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'break_start_date' => 'nullable|date_format:Y-m-d',
            'break_end_date' => 'nullable|date_format:Y-m-d',
            'competition_id' => 'required|numeric|min:1',
        ]);

        $ruleCreated = auth()->user()->addRule($attributes);

        if ($ruleCreated !== null) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('rules.admin-show', ['competition' => $competition->id, 'rule' => $ruleCreated->id]);
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
        return view('rules.admin-show', compact('competition', 'rule'));
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
        return view('rules.edit', compact('competition', 'rule'));
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
        $attributes = $request->validate([
            'name' => 'required|min:2|max:100',
            'system' => 'required|min:2|max:100',
            'priority' => 'required|numeric|min:1',
            'number_of_rounds' => 'nullable|numeric',
            'number_of_qualifiers' => 'nullable|numeric',
            'number_of_descending' => 'nullable|numeric',
            'match_duration' => 'nullable|numeric',
            'matches_day_min' => 'nullable|numeric',
            'matches_day_max' => 'nullable|numeric',
            'team_matches_day_round_min' => 'nullable|numeric',
            'team_matches_day_round_max' => 'nullable|numeric',
            'match_days_times' => 'required|json|min:1|max:100',
            'case_of_draw' => 'required|min:2|max:100',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'break_start_date' => 'nullable|date_format:Y-m-d',
            'break_end_date' => 'nullable|date_format:Y-m-d',
            'competition_id' => 'required|numeric|min:1',
        ]);

        if ($rule->update($attributes)) {
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
