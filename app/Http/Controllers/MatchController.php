<?php

namespace App\Http\Controllers;

use App\Match;
use App\Repositories\Matches;
use App\Competition;
use App\Rule;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition)
    {
        $lastRuleByPriority = $competition->getLastRuleByPriority();

        if ($lastRuleByPriority !== null) {
            $lastMatchByRound = $lastRuleByPriority->getLastMatchByRound();

            if ($lastMatchByRound !== null) {
                return redirect()->route('matches.params-index', ['competition' => $competition->id, 'rule' => $lastRuleByPriority->id, 'round' => $lastMatchByRound->round]);
            } else {
                session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
                return redirect()->back();
            }
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
            return redirect()->back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Rule  $rule
     * @param  int $actualRound
     * @param  \App\Repositories\Matches  $matchesRepository
     * @return \Illuminate\Http\Response
     */
    public function paramsIndex(Competition $competition, Rule $rule, $actualRound = null, Matches $matchesRepository)
    {
        $matchesRounds = null;
        $lastRound = null;
        $rounds = [];

        $matches = $matchesRepository->getMatchesByCompetitionRule($competition->id, $rule->id);

        if ($matches !== null) {
            $matchesRounds = collect($matches)->unique('round')->sortDesc()->values();

            if ($matchesRounds !== null) {
                foreach ($matchesRounds as $matchesRound) {
                    $rounds[] = $matchesRound->round;
                }
            }

            if ($actualRound !== null) {
                $actualRound = (int) $actualRound;
                $matches = $matchesRepository->getMatchesByCompetitionRuleRound($competition->id, $rule->id, $actualRound);
            }
        }

        return view('matches.index', compact('competition', 'rule', 'actualRound', 'lastRound', 'matches', 'rounds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function scheduleIndex(Competition $competition)
    {
        return view('matches.schedule-index', compact('competition'));
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
            'start_time' => 'required',
            'home_team_id' => 'required|numeric|min:1',
            'away_team_id' => 'required|numeric|min:1',
            'home_team_score' => 'nullable|numeric',
            'away_team_score' => 'nullable|numeric',
            'home_team_halftime_score' => 'nullable|numeric',
            'away_team_halftime_score' => 'nullable|numeric',
            'rule_id' => 'required|numeric|min:1',
            'competition_id' => 'required|numeric|min:1',
        ]);

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
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }
}
