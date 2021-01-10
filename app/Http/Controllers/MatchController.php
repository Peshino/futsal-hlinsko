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
    public function index(Competition $competition, $section = 'matches')
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
     * @param  \App\Repositories\Matches  $matchesRepository
     * @return \Illuminate\Http\Response
     */
    public function paramsIndex(Competition $competition, Rule $rule, $actualRound = null)
    {
        $matchesRepository = new Matches;
        $rounds = $matchesRepository->getRoundsByCompetitionRule($competition->id, $rule->id);
        $matches = $matchesRepository->getMatchesByCompetitionRule($competition->id, $rule->id);

        if ($actualRound !== null) {
            $actualRound = (int) $actualRound;
            $matches = $matchesRepository->getMatchesByCompetitionRuleRound($competition->id, $rule->id, $actualRound);
        }

        return view('matches.index', compact('competition', 'rule', 'actualRound', 'matches', 'rounds'));
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
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function tableParamsIndex(Competition $competition, Rule $rule, $toRound = null)
    {
        $matchesRepository = new Matches;

        $rounds = $matchesRepository->getRoundsByCompetitionRule($competition->id, $rule->id);
        $tableData = $matchesRepository->getTableData($competition, $rule, $toRound);

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
     * @param  \App\Competition  $competition
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition, Match $match)
    {
        return view('matches.show', compact('competition', 'match'));
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
        return view('matches.edit', compact('competition', 'match'));
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

        if ($match->update($attributes)) {
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
