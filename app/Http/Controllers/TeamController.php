<?php

namespace App\Http\Controllers;

use App\Team;
use App\Competition;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition)
    {
        return view('teams.index', compact('competition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition)
    {
        return view('teams.create', compact('competition'));
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
            'squad' => 'required|min:1|max:10',
            'competition_id' => 'required|numeric|min:1'
        ]);

        $teamCreated = auth()->user()->addTeam($attributes);

        if ($teamCreated !== null && $teamCreated !== false) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
            return redirect()->route('teams.admin-show', ['competition' => $competition->id, 'team' => $teamCreated->id]);
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i> <p>Záznam již existuje!</p>');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition, Team $team)
    {
        return view('teams.show', compact('competition', 'team'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function adminShow(Competition $competition, Team $team)
    {
        return view('teams.admin-show', compact('competition', 'team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition, Team $team)
    {
        return view('teams.edit', compact('competition', 'team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition, Team $team)
    {
        $attributes = $request->validate([
            'name' => 'required|min:2|max:100',
            'squad' => 'required|min:1|max:10',
            'competition_id' => 'required|numeric|min:1',
        ]);

        if ($team->update($attributes)) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('teams.admin-show', ['competition' => $competition->id, 'team' => $team->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, Team $team)
    {
        if ($team->delete()) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('competitions.admin-show', ['competition' => $competition->id]);
    }
}
