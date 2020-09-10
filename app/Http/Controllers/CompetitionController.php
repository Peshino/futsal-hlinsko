<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Repositories\Competitions;
use App\Season;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('competitions.index', compact(''));
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
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        // dd($competition);
        return view('competitions.show', compact('competition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition)
    {
        //
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
        //
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
