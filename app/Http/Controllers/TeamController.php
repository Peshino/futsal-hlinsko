<?php

namespace App\Http\Controllers;

use App\Team;
use App\Competition;
use App\Repositories\Players;
use App\Repositories\Games;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud_teams')->only(['create', 'store', 'edit', 'update', 'destroy']);
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
        $otherCompetitions = $competition->season->competitions->whereNotIn('id', $competition->id)->pluck('id')->toArray();
        $otherTeams = Team::whereIn('competition_id', $otherCompetitions)->orderBy('name', 'asc')->get();

        return view('teams.create', compact('competition', 'otherTeams'));
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
            'name_short' => 'required|min:2|max:10',
            'logo' => 'nullable|string|max:100',
            'web_presentation' => 'nullable|string|max:100',
            'superior_team_id' => 'nullable|numeric',
            'inferior_team_id' => 'nullable|numeric',
            'competition_id' => 'required|numeric|min:1'
        ]);

        $attributes['name_short'] = strtoupper($attributes['name_short']);
        // history_code - vytvořit nový jen pokud nepřebírám od historického týmu (pro zachování kódu týmu)
        $attributes['history_code'] = time() . '_' . random_int(10000, 99999);

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
        $otherCompetitions = $competition->season->competitions->whereNotIn('id', $competition->id)->pluck('id')->toArray();
        $otherTeams = Team::whereIn('competition_id', $otherCompetitions)->orderBy('name', 'asc')->get();

        return view('teams.edit', compact('competition', 'team', 'otherTeams'));
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
            'name_short' => 'required|min:2|max:10',
            'logo' => 'nullable|string|max:100',
            'web_presentation' => 'nullable|string|max:100',
            'superior_team_id' => 'nullable|numeric',
            'inferior_team_id' => 'nullable|numeric',
            'competition_id' => 'required|numeric|min:1'
        ]);

        $attributes['name_short'] = strtoupper($attributes['name_short']);

        // history_code - vytvořit nový jen pokud nepřebírám od historického týmu (pro zachování kódu týmu)
        if ($team->history_code === null) {
            $attributes['history_code'] = time() . '_' . random_int(10000, 99999);
        }

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

    /**
     * Display the team players.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function getTeamPlayers(Competition $competition, Team $team)
    {
        $playersRepository = new Players;

        $teamPlayers = $playersRepository->getPlayersFiltered($competition, $team);

        return view('teams.show', compact('competition', 'team', 'teamPlayers'));
    }

    /**
     * Display the team results.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function getTeamResults(Competition $competition, Team $team)
    {
        $gamesRepository = new Games;

        $teamResults = $gamesRepository->getGamesFiltered($competition, null, $team, 'results');

        return view('teams.show', compact('competition', 'team', 'teamResults'));
    }

    /**
     * Display the team schedule.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function getTeamSchedule(Competition $competition, Team $team)
    {
        $gamesRepository = new Games;

        $teamSchedule = $gamesRepository->getGamesFiltered($competition, null, $team, 'schedule');

        return view('teams.show', compact('competition', 'team', 'teamSchedule'));
    }
}
