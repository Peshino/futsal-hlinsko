<?php

namespace App\Http\Controllers;

use App\Team;
use App\Goal;
use App\Rule;
use App\Competition;
use App\Repositories\Goals;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:crud_goals')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition, Rule $rule = null, Team $team = null)
    {
        $goalsRepository = new Goals;
        $rule = $rule === null ? $competition->getLastRuleByPriority() : $rule;

        if ($rule !== null) {
            $goals = $goalsRepository->getSummedGoalsFiltered($competition, $rule);
            $goalsTeams = Team::whereIn('id', $goals->unique('team_id')->pluck('team_id')->toArray())->orderBy('name')->get();

            if ($team !== null) {
                $goals = $goalsRepository->getSummedGoalsFiltered($competition, $rule, null, $team);
            }

            return view('goals.index', compact('competition', 'goals', 'rule', 'goalsTeams', 'team'));
        } else {
            return redirect()->route('rules.create', ['competition' => $competition->id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        //
    }
}
