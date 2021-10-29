<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Season;
use App\Repositories\Competitions;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud_competitions')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('competitions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function create(Season $season)
    {
        return view('competitions.create', compact('season'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Season  $season
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Season $season, Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|min:2|max:100',
            'season_id' => 'required',
        ]);

        $competitionCreated = auth()->user()->addCompetition($attributes);

        if ($competitionCreated !== null) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
            return redirect()->route('competitions.admin-show', ['competition' => $competitionCreated->id]);
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        return view('competitions.show', compact('competition'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function adminShow(Competition $competition)
    {
        return view('competitions.admin-show', compact('competition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition, Season $season)
    {
        return view('competitions.edit', compact('competition', 'season'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition)
    {
        $attributes = $request->validate([
            'name' => 'required|min:2|max:100',
            'season_id' => 'required',
        ]);

        if ($competition->update($attributes)) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('competitions.admin-show', $competition->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition)
    {
        //
    }

    /**
     * Get the specified resource by id.
     *
     * @param  $seasonId
     * @param  \App\Repositories\Competitions  $competitionsRepository
     * @return \Illuminate\Http\Response
     */
    public function getCompetitionsBySeason($seasonId = null, Competitions $competitionsRepository)
    {
        if ($seasonId !== null) {
            $competitionsBySeason = $competitionsRepository->getCompetitionsBySeason($seasonId);
        } else {
            $competitionsBySeason = null;
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return $competitionsBySeason;
    }
}
