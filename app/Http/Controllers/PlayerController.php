<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use App\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:crud_players')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition, Team $team)
    {
        return view('players.index', compact('competition', 'team'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition, Team $team)
    {
        return view('players.create', compact('competition', 'team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Competition $competition, Team $team)
    {
        $attributes = $request->validate([
            'firstname' => 'required|min:2|max:100',
            'lastname' => 'required|min:2|max:100',
            'jersey_number' => 'nullable|numeric|max:999',
            'birthdate' => 'nullable|date_format:Y-m-d',
            'position' => 'nullable|string|max:100',
            'photo' => 'nullable|string|max:100',
            'futis_code' => 'nullable|numeric',
            'height' => 'nullable|numeric|max:999',
            'nationality' => 'nullable|string|max:100',
            'team_id' => 'required|numeric|min:1',
            'competition_id' => 'required|numeric|min:1'
        ]);

        // history_code - vytvořit nový jen pokud nepřebírám od historického týmu (pro zachování kódu týmu)
        $attributes['history_code'] = time() . '_' . random_int(10000, 99999);

        $playerCreated = auth()->user()->addPlayer($attributes);

        if ($playerCreated !== null) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
            return redirect()->route('players.admin-show', ['competition' => $competition->id, 'team' => $team->id, 'player' => $playerCreated->id]);
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition, Team $team, Player $player)
    {
        $age = null;

        if ($player->birthdate !== null) {
            $age = Carbon::parse($player->birthdate)->age;
        }

        return view('players.show', compact('competition', 'team', 'player', 'age'));
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function adminShow(Competition $competition, Team $team, Player $player)
    {
        return view('players.admin-show', compact('competition', 'team', 'player'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition, Team $team, Player $player)
    {
        return view('players.edit', compact('competition', 'team', 'player'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition, Team $team, Player $player)
    {
        $attributes = $request->validate([
            'firstname' => 'required|min:2|max:100',
            'lastname' => 'required|min:2|max:100',
            'jersey_number' => 'nullable|numeric|max:999',
            'birthdate' => 'nullable|date_format:Y-m-d',
            'position' => 'nullable|string|max:100',
            'photo' => 'nullable|string|max:100',
            'futis_code' => 'nullable|numeric',
            'height' => 'nullable|numeric|max:999',
            'nationality' => 'nullable|string|max:100',
            'team_id' => 'required|numeric|min:1',
            'competition_id' => 'required|numeric|min:1'
        ]);

        // history_code - vytvořit nový jen pokud nepřebírám od historického týmu (pro zachování kódu týmu)
        if ($player->history_code === null) {
            $attributes['history_code'] = time() . '_' . random_int(10000, 99999);
        }

        if ($player->update($attributes)) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('players.admin-show', ['competition' => $competition->id, 'team' => $team->id, 'player' => $player->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @param  \App\Team  $team
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, Team $team, Player $player)
    {
        if ($player->delete()) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('teams.admin-show', ['competition' => $competition->id, 'team' => $team->id]);
    }
}
