<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use App\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\Games;
use App\Repositories\Goals;
use App\Repositories\Cards;

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
        $attributes['history_code'] = bin2hex(random_bytes(8));

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

        $gamesRepository = new Games;
        $goalsRepository = new Goals;
        $cardsRepository = new Cards;

        $goals = $goalsRepository->getSummedGoalsFiltered($competition, null, null, null, $player, 'desc', 3);
        $yellowCards = $cardsRepository->getSummedCardsFiltered($competition, null, null, null, $player, 'desc', 'yellow', 3);
        $redCards = $cardsRepository->getSummedCardsFiltered($competition, null, null, null, $player, 'desc', 'red', 3);

        if ($player->birthdate !== null) {
            $age = Carbon::parse($player->birthdate)->age;
        }

        return view('players.show', compact('competition', 'team', 'player', 'age', 'goals', 'yellowCards', 'redCards'));
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
            $attributes['history_code'] = bin2hex(random_bytes(8));
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

    public function sync(Competition $competition)
    {
        $archive = request('archive');
        $success = false;

        $data = DB::connection('mysql_old_db')->select('SELECT * FROM `players` WHERE `archive` = ' . $archive . '');
        $historyCodes = [];
        $incomingPlayerIds = [];

        foreach ($data as $key => $item) {
            $class = (int) $item->class;
            $archive = (int) $item->archive;
            $jmeno = trim(str_replace('  ', ' ', $item->jmeno));
            $tym = trim($item->tym);
            $userId = 3;
            $name = explode(' ', $jmeno);
            $firstname = trim($name[1]);
            $lastname = trim($name[0]);

            if ($tym === 'DTJ Juventus Hlinsko B') {
                $tym = 'DTJ Juventus Hlinsko';
            }

            if (strpos($tym, 'FC Norton Skute') !== false) {
                $tym = 'FC Norton Skuteč';
            } elseif (strpos($tym, 'Norton Skute') !== false) {
                $tym = 'Norton Skuteč';
            }

            if (strpos($tym, 'Sokol Holet') !== false) {
                $tym = 'Sokol Holetín';
            }

            $jmenoTym = $lastname . ' ' . $firstname . '-' . $tym;

            $team = Team::where('name', $tym)->where('competition_id', $competition->id)->first();

            if ($team === null) {
                continue;
            }

            $player = Player::query()->where(['firstname' => $firstname, 'lastname' => $lastname, 'team_id' => $team->id, 'competition_id' => $competition->id])->first();

            if ($player !== null) {
                $historyCodes[$jmenoTym] = $player->history_code;
            }

            if (array_key_exists($jmenoTym, $historyCodes)) {
                $historyCode = $historyCodes[$jmenoTym];
            } else {
                $historyCodes[$jmenoTym] = $historyCode = bin2hex(random_bytes(8));
            }

            if ($player !== null) {
                // Player exists, update details if necessary
            } else {
                // Player does not exist, create a new one
                $player = Player::create([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'history_code' => $historyCode,
                    'team_id' => $team->id,
                    'user_id' => $userId,
                    'competition_id' => $competition->id,
                ]);
            }

            $incomingPlayerIds[] = $player->id;
        }

        Player::where('competition_id', $competition->id)
            ->whereNotIn('id', $incomingPlayerIds)
            ->delete();

        $success = true;

        if ($success) {
            session()->flash('flash_message_success', '<i class="fas fa-check"></i>');
        } else {
            session()->flash('flash_message_danger', '<i class="fas fa-times"></i>');
        }

        return redirect()->route('teams.index', ['competition' => $competition->id]);
    }
}
